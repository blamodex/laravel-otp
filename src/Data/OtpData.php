<?php

declare(strict_types=1);

namespace Blamodex\Otp\Data;

readonly class OtpData
{
    /**
     * @param string $password The raw (non-hashed) one-time password.
     * @param string $passwordHash The hashed one-time password.
     */
    public function __construct(
        public string $password,
        public string $passwordHash,
    ) {}
}