<?php

declare(strict_types=1);

namespace Blamodex\Otp\Tests\Unit;

use Blamodex\Otp\Tests\Fixtures\DummyOtpUser;
use Blamodex\Otp\Tests\TestCase;

class OneTimePasswordableTest extends TestCase
{
    /**
     * It returns true when verifying the correct OTP.
     */
    public function test_verify_otp_returns_true_on_password_match(): void
    {
        $dummyOtpUser = DummyOtpUser::create();

        $password = $dummyOtpUser->generateOtp();

        $this->assertTrue($dummyOtpUser->verifyOtp($password));
    }

    /**
     * It returns false when verifying an incorrect OTP.
     */
    public function test_verify_otp_returns_false_on_password_mismatch(): void
    {
        $dummyOtpUser = DummyOtpUser::create();

        $password = $dummyOtpUser->generateOtp();

        $this->assertFalse($dummyOtpUser ->verifyOtp($password . '123'));
    }

    /**
     * It expires the previous OTP when a new one is generated.
     */
    public function test_passwords_are_expired_when_a_new_password_is_created(): void
    {
        $dummyOtpUser = DummyOtpUser::create();

        $passwordOne = $dummyOtpUser->generateOtp();
        $passwordTwo = $dummyOtpUser->generateOtp();

        $this->assertFalse($dummyOtpUser->verifyOtp($passwordOne));
        $this->assertTrue($dummyOtpUser->verifyOtp($passwordTwo));
    }
}
