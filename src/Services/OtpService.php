<?php

namespace Blamodex\Otp\Services;

use Blamodex\Otp\Contracts\OneTimePasswordableInterface;
use Blamodex\Otp\Models\OneTimePassword;
use Blamodex\Otp\Services\OtpGenerator;

/**
 * Service responsible for generating, verifying, and managing OTPs
 * for models that implement OneTimePasswordableInterface.
 */
class OtpService
{
    /**
     * Generate an OTP for the given model.
     *
     * @param OneTimePasswordableInterface $model The model that will own the OTP.
     * @return string The raw one-time password string.
     */
    public function generate(OneTimePasswordableInterface $model): string
    {
        $otp = new OneTimePassword();
        $otp->one_time_passwordable_id = $model->getKey();
        $otp->one_time_passwordable_type = get_class($model);

        $password = app(OtpGenerator::class)->generate($otp);

        $this->expireAllFor($model);
        $otp->save();

        return $password;
    }

    /**
     * Verify a given OTP attempt for the model.
     *
     * @param OneTimePasswordableInterface $model The model to verify against.
     * @param string $attempt The password attempt to validate.
     * @return bool True if the attempt is valid, false otherwise.
     */
    public function verify(OneTimePasswordableInterface $model, string $attempt): bool
    {
        $otp = $this->getCurrent($model);
        if ($otp && $otp->isValid($attempt)) {
            $otp->markAsUsed();
            return true;
        }
        return false;
    }

    /**
     * Expire all active (unused) OTPs for the given model.
     *
     * @param OneTimePasswordableInterface $model The model for which to expire OTPs.
     * @return void
     */
    private function expireAllFor(OneTimePasswordableInterface $model): void
    {
        OneTimePassword::expireAllFor($model);
    }

    /**
     * Retrieve the most recent OTP for the given model.
     *
     * @param OneTimePasswordableInterface $model The model to retrieve the OTP for.
     * @param bool $withExpired Whether to include expired OTPs in the result.
     * @return OneTimePassword|null The latest OTP, or null if none found.
     */
    private function getCurrent(OneTimePasswordableInterface $model, bool $withExpired = false): ?OneTimePassword
    {
        return OneTimePassword::getCurrentFor($model, $withExpired);
    }
}
