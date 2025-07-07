<?php

namespace Blamodex\Otp\Tests\Unit;

use Blamodex\Otp\Tests\TestCase;
use Blamodex\Otp\Traits\OneTimePasswordable;

class TraitTest extends TestCase
{
    use OneTimePasswordable;

    /**
     * A basic test example.
     */
    public function test_generate_otp_returns_otp_of_correct_length(): void
    {
        $this->id = 1;
        $password = $this->generateOtp();     

        $passwordLength = strlen($password);

        $this->assertEquals($passwordLength, config('blamodex.otp.length'));
    }

    /**
     * A basic test example.
     */
    public function test_verify_otp_returns_true_on_password_match(): void
    {
        $this->id = 1;
        $password = $this->generateOtp();

        $this->assertTrue($this->verifyOtp($password));
    }

    /**
     * A basic test example.
     */
    public function test_verify_otp_returns_false_on_password_mismatch(): void
    {
        $this->id = 1;
        $password = $this->generateOtp();

        $this->assertFalse($this->verifyOtp($password . '123'));
    }

    /**
     * A basic test example.
     */
    public function test_is_current_otp_expired_returns_false_for_newly_created_password(): void
    {
        $this->id = 1;
        $password = $this->generateOtp();

        $this->assertFalse($this->isCurrentOtpExpired());
    }

    /**
     * A basic test example.
     */
    public function test_passwords_are_expired_when_a_new_password_is_created(): void
    {
        $this->id = 1;
        $passwordOne = $this->generateOtp();
        $passwordTwo = $this->generateOtp();

        $this->assertFalse($this->verifyOtp($passwordOne));
        $this->assertTrue($this->verifyOtp($passwordTwo));
    }


}
