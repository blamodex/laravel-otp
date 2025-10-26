<?php

namespace Blamodex\Otp\Tests\Unit;

use Blamodex\Otp\Tests\TestCase;
use Blamodex\Otp\Models\OneTimePassword;
use Blamodex\Otp\Services\OtpGenerator;
use Carbon\Carbon;

class OtpGeneratorTest extends TestCase
{
    /**
     * It returns a password of correct length
     *
     * @test
     */
    public function test_password_returned_is_correct_length(): void
    {
        $otpGenerator = new OtpGenerator();

        $oneTimePassword = $otpGenerator->generate(new OneTimePassword());

        $passwordLength = strlen($oneTimePassword->password);

        $this->assertEquals($passwordLength, config('blamodex.otp.length'));
        $this->assertTrue(
            password_verify(
                $oneTimePassword->password,
                $oneTimePassword->passwordHash
            )
        );
    }
}
