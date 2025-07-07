<?php

namespace Blamodex\Otp\Tests\Unit;

use Blamodex\Otp\Tests\TestCase;
use Blamodex\Otp\Models\OneTimePassword;
use Blamodex\Otp\Services\OtpGenerator;
use Carbon\Carbon;

class OtpGeneratorTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_password_returned_is_correct_length(): void
    {
        $otpGenerator = new OtpGenerator;

        $oneTimePassword = $otpGenerator->generate(new OneTimePassword);

        $passwordLength = strlen($oneTimePassword);

        $this->assertEquals($passwordLength, config('blamodex.otp.length'));
    }
}
