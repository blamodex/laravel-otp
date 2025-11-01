<?php

declare(strict_types=1);

namespace Blamodex\Otp\Traits;

use Blamodex\Otp\Models\OneTimePassword;
use Blamodex\Otp\Services\OtpService;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait OneTimePasswordable
{
    public function oneTimePasswords(): MorphMany
    {
        return $this->morphMany(OneTimePassword::class, 'one_time_passwordable');
    }

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
