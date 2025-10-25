<?php

namespace Blamodex\Otp\Tests\Unit;

use Blamodex\Otp\Services\OtpService;
use Blamodex\Otp\Tests\TestCase;
use Blamodex\Otp\Tests\Fixtures\DummyOtpUser;
use Illuminate\Database\Eloquent\Relations\Relation;

class OtpServiceTest extends TestCase
{
    /**
     * It returns a password of correct length
     */
    public function test_verify_returns_true_for_correct_password(): void
    {
        $user = DummyOtpUser::create();

        $otpService = new OtpService();

        $oneTimePassword = $otpService->generate($user);

        $this->assertTrue($otpService->verify($user, $oneTimePassword));
    }

    /**
     * It returns a false for incorrect passwords
     */
    public function test_verify_returns_false_for_incorrect_password(): void
    {
        $user = DummyOtpUser::create();

        $otpService = new OtpService();

        $otpService->generate($user);

        $this->assertFalse($otpService->verify($user, 'foobar'));
    }

    /**
     * It verifies a OTP only once
     */
    public function test_verify_only_works_once_per_password(): void
    {
        $user = DummyOtpUser::create();

        $otpService = new OtpService();

        $oneTimePassword = $otpService->generate($user);

        $this->assertTrue($otpService->verify($user, $oneTimePassword));
        $this->assertFalse($otpService->verify($user, $oneTimePassword));
    }

    /**
     * It returns a password of correct length
     */
    public function test_generate_uses_the_morph_class(): void
    {
        $user = DummyOtpUser::create();

        $otpService = new OtpService();

        $otpService->generate($user);

        $this->assertEquals('Blamodex\Otp\Tests\Fixtures\DummyOtpUser', $user->getMorphClass());

        Relation::morphMap([
            'user' => DummyOtpUser::class,
        ]);

        $user = DummyOtpUser::create();

        $otpService->generate($user);

        $this->assertEquals('user', $user->getMorphClass());
    }
}
