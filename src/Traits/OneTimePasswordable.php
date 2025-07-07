<?php

namespace Blamodex\Otp\Traits;

use Blamodex\Otp\Services\OtpService;

trait OneTimePasswordable
{
    /**
     * Generate and store a new password.
     */
    public function generateOtp(): string
    {
         return app(OtpService::class)->generate($this);
    }

    /**
     * Check if a given password matches the stored one.
     */
    public function verifyOtp(string $attempt): bool
    {
        return app(OtpService::class)->verify($this, $attempt);
    }
}
