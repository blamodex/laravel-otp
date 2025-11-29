<?php

declare(strict_types=1);

namespace Blamodex\Otp\Contracts;

use Blamodex\Otp\Data\OtpData;

interface OtpGeneratorInterface
{
    /**
     * Generate a new OTP string, hash it, and return it
     *
     * @return OtpData
     */
    public function generate(): OtpData;
}
