<?php

declare(strict_types=1);

namespace Blamodex\Otp\Services;

use Blamodex\Otp\Contracts\OneTimePasswordableInterface;
use Blamodex\Otp\Contracts\OtpGeneratorInterface;
use Blamodex\Otp\Events\OneTimePasswordCreated;
use Blamodex\Otp\Models\OneTimePassword;
use Illuminate\Support\Facades\DB;

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
        $otpData = app(OtpGeneratorInterface::class)->generate();

        DB::transaction(function () use ($model, $otpData) {
            $otp = new OneTimePassword();
            $otp->one_time_passwordable_id = $model->getKey();
            $otp->one_time_passwordable_type = $model->getMorphClass();
            $otp->password_hash = $otpData->passwordHash;
            $otp->expired_at = now()->addSeconds(config('blamodex.otp.expiry'));
            $otp->save();

            $this->expireAllFor($model);

            event(new OneTimePasswordCreated($otp));
        });

        return $otpData->password;
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
     * @return OneTimePassword|null The latest OTP, or null if none found.
     */
    private function getCurrent(OneTimePasswordableInterface $model): ?OneTimePassword
    {
        return OneTimePassword::getCurrentFor($model);
    }
}
