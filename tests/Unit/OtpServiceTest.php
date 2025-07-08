<?php

namespace Blamodex\Otp\Tests\Unit;

use Blamodex\Otp\Contracts\OneTimePasswordableInterface;
use Blamodex\Otp\Services\OtpService;
use Blamodex\Otp\Tests\TestCase;
use Blamodex\Otp\Tests\Fixtures\DummyOtpUser;
use Illuminate\Database\Eloquent\Model;

/**
 * @covers \Blamodex\Otp\Services\OtpService
 */
class OtpServiceTest extends TestCase
{
    /**
     * It returns a password of correct length
     *
     * @test
     */
    public function test_verify_returns_true_for_correct_password(): void
    {
        $user = DummyOtpUser::create();

        $otpService = new OtpService;

        $oneTimePassword = $otpService->generate($user);

        $this->assertTrue($otpService->verify($user, $oneTimePassword));
    }

    /**
     * It returns a false for incorrect passwords
     *
     * @test
     */
    public function test_verify_returns_false_for_incorrect_password(): void
    {
        $user = DummyOtpUser::create();

        $otpService = new OtpService;

        $oneTimePassword = $otpService->generate($user);

        $this->assertFalse($otpService->verify($user, 'foobar'));
    }

    /**
     * It verifies a OTP only once
     *
     * @test
     */
    public function test_verify_only_works_once_per_password(): void
    {
        $user = DummyOtpUser::create();

        $otpService = new OtpService;

        $oneTimePassword = $otpService->generate($user);

        $this->assertTrue($otpService->verify($user, $oneTimePassword));
        $this->assertFalse($otpService->verify($user, $oneTimePassword));
    }
}
