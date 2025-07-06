<?php

namespace Blamodex\Otp\Tests\Unit;

use Blamodex\Otp\Tests\TestCase;
use Blamodex\Otp\Models\OneTimePassword;
use Carbon\Carbon;

class ModelTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_password_returned_is_correct_length(): void
    {
        $otp = new OneTimePassword;

        $oneTimePassword = $otp->generate();

        $passwordLength = strlen($oneTimePassword);

        $this->assertEquals($passwordLength, config('blamodex.otp.length'));
    }

    /**
     * A basic test example.
     */
    public function test_password_generate_sets_expiry_in_future(): void
    {
        $otp = new OneTimePassword;

        $oneTimePassword = $otp->generate();

        $this->assertNotNull($otp->expired_at);

        $this->assertInstanceOf(Carbon::class, $otp->expired_at);
    }

    /**
     * A basic test example.
     */
    public function test_password_is_valid_validates_password_correctly(): void
    {
        $otp = new OneTimePassword;

        $oneTimePassword = $otp->generate();

        $this->assertTrue($otp->isValid($oneTimePassword));
    }

    /**
     * A basic test example.
     */
    public function test_password_is_valid_invalidates_incorrect_password(): void
    {
        $otp = new OneTimePassword;

        $oneTimePassword = $otp->generate();

        $this->assertFalse($otp->isValid($oneTimePassword . '123'));
    }

    /**
     * A basic test example.
     */
    public function test_password_use_sets_used_at_as_datetime(): void
    {
        $otp = new OneTimePassword;
        $otp->generate();

        $otp->one_time_passwordable_id = 1;
        $otp->one_time_passwordable_type = 'User';

        $otp->use();

        $this->assertInstanceOf(Carbon::class, $otp->used_at);
    }


}
