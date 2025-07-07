<?php

namespace Blamodex\Otp\Services;

use Blamodex\Otp\Models\OneTimePassword;

class OtpGenerator
{
    public function generate(OneTimePassword $otp): string
    {
        $alphabet = config('blamodex.otp.alphabet');
        $length = config('blamodex.otp.length');
        $algorithm = config('blamodex.otp.algorithm');
        $expiry = config('blamodex.otp.expiry');

        $password = collect(range(1, $length))
            ->map(fn () => $alphabet[random_int(0, strlen($alphabet) - 1)])
            ->implode('');

        $otp->password_hash = password_hash($password, $algorithm);
        $otp->expired_at = now()->addSeconds($expiry);

        return $password;
    }
}