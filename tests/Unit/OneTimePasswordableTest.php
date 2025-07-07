<?php

namespace Blamodex\Otp\Tests\Unit;

use Blamodex\Otp\Contracts\OneTimePasswordableInterface;
use Blamodex\Otp\Tests\TestCase;
use Blamodex\Otp\Traits\OneTimePasswordable;


class OneTimePasswordableTest extends TestCase implements OneTimePasswordableInterface
{
    use OneTimePasswordable;

    public function getKey() {
        return 1;
    }

    public function getMorphClass() {
        return 'foo';
    }

    /**
     * A basic test example.
     */
    public function test_verify_otp_returns_true_on_password_match(): void
    {
        $password = $this->generateOtp();

        $this->assertTrue($this->verifyOtp($password));
    }

    /**
     * A basic test example.
     */
    public function test_verify_otp_returns_false_on_password_mismatch(): void
    {
        $password = $this->generateOtp();

        $this->assertFalse($this->verifyOtp($password . '123'));
    }

    /**
     * A basic test example.
     */
    public function test_passwords_are_expired_when_a_new_password_is_created(): void
    {
        $passwordOne = $this->generateOtp();
        $passwordTwo = $this->generateOtp();

        $this->assertFalse($this->verifyOtp($passwordOne));
        $this->assertTrue($this->verifyOtp($passwordTwo));
    }


}
