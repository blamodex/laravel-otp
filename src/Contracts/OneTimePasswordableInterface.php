<?php

namespace Blamodex\Otp\Contracts;

interface OneTimePasswordableInterface
{
    public function getKey();
    public function getMorphClass();
}
