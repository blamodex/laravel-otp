<?php

namespace Blamodex\Otp\Tests\Unit;

use Blamodex\Otp\Tests\TestCase;
use Blamodex\Otp\Models\OneTimePassword;

class ModelTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_password_returned_is_correct_length(): void
    {
        $otp = new OneTimePassword;

        $password = $otp->generatePassword();

        $passwordLength = strlen($password);

        $this->assertEquals($passwordLength, config('blamodex.otp.length'));
    }
}
