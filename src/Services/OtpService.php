<?php

namespace Blamodex\Otp\Services;

use Blamodex\Otp\Contracts\OneTimePasswordableInterface;
use Blamodex\Otp\Models\OneTimePassword;
use Blamodex\Otp\Services\OtpGenerator;

class OtpService
{
    public function generate(OneTimePasswordableInterface $model): string
    {
        $otp = new OneTimePassword();
        $otp->one_time_passwordable_id = $model->getKey();
        $otp->one_time_passwordable_type = get_class($model);

        $password = app(OtpGenerator::class)->generate($otp);

        $this->expireAllFor($model);
        $otp->save();

        return $password; // or return separately
    }

    public function verify(OneTimePasswordableInterface $model, string $attempt): bool
    {
        $otp = $this->getCurrent($model);
        if ($otp && $otp->isValid($attempt)) {
            $otp->markAsUsed();
            return true;
        }
        return false;
    }

    private function expireAllFor(OneTimePasswordableInterface $model): void
    {
        OneTimePassword::expireAllFor($model);
    }

    private function getCurrent(OneTimePasswordableInterface $model, bool $withExpired = false): ?OneTimePassword
    {
        return OneTimePassword::getCurrentFor($model, $withExpired);
    }
}
