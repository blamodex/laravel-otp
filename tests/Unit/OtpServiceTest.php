<?php

namespace Blamodex\Otp\Tests\Unit;

use Blamodex\Otp\Contracts\OneTimePasswordableInterface;
use Blamodex\Otp\Services\OtpService;
use Blamodex\Otp\Tests\TestCase;
use Blamodex\Otp\Tests\Fixtures\DummyOtpUser;
use Illuminate\Database\Eloquent\Model;

class OtpServiceTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_verify_returns_true_for_correct_password(): void
    {
        $user = DummyOtpUser::create();

        $otpService = new OtpService;

        $oneTimePassword = $otpService->generate($user);

        $this->assertTrue($otpService->verify($user, $oneTimePassword));
    }

    /**
     * A basic test example.
     */
    public function test_verify_returns_false_for_incorrect_password(): void
    {
        $user = DummyOtpUser::create();

        $otpService = new OtpService;

        $oneTimePassword = $otpService->generate($user);

        $this->assertFalse($otpService->verify($user, 'foobar'));
    }
}
