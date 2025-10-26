<?php

namespace Blamodex\Otp\Services;

use Blamodex\Otp\Contracts\OtpGeneratorInterface;
use Blamodex\Otp\Data\OtpData;

/**
 * Service responsible for generating one-time passwords (OTPs).
 */
class OtpGenerator implements OtpGeneratorInterface
{
    public function generate(): OtpData
    {
        $alphabet = config('blamodex.otp.alphabet');
        $length = config('blamodex.otp.length');
        $algorithm = config('blamodex.otp.algorithm');

        $password = collect(range(1, $length))
            ->map(fn () => $alphabet[random_int(0, strlen($alphabet) - 1)])
            ->implode('');

        return new OtpData(
            $password,
            password_hash($password, $algorithm)
        );
    }
}
