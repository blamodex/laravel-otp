<?php

namespace Blamodex\Otp\Tests\Unit;

use Blamodex\Otp\Services\OtpService;
use Blamodex\Otp\Tests\TestCase;
use Blamodex\Otp\Tests\Fixtures\DummyOtpUser;
use Blamodex\Otp\Validators\OtpValidator;

/**
 * @covers \Blamodex\Otp\Services\OtpService
 */
class OtpValidatorTest extends TestCase
{
    /**
     * It passes with correct password length and correct characters
     *
     * @test
     */
    public function test_validator_passes_for_correct_password_length(): void
    {
        $user = DummyOtpUser::create();

        $otpService = new OtpService();

        $oneTimePassword = $otpService->generate($user);

        $validator = new OtpValidator($oneTimePassword);

        $this->assertTrue($validator->passes());
    }

    /**
     * It fails with incorrect password length
     *
     * @test
     */
    public function test_validator_fails_for_incorrect_password_length(): void
    {
        $user = DummyOtpUser::create();

        $otpService = new OtpService();

        $oneTimePassword = $otpService->generate($user);

        $validator = new OtpValidator($oneTimePassword . '1');

        $this->assertFalse($validator->passes());
    }

    /**
     * It fails with incorrect characters
     *
     * @test
     */
    public function test_validator_fails_for_incorrect_characters(): void
    {
        $user = DummyOtpUser::create();

        $otpService = new OtpService();

        $oneTimePassword = $otpService->generate($user);

        $oneTimePassword = substr_replace($oneTimePassword, '-', 0, 1);

        $validator = new OtpValidator($oneTimePassword);

        $this->assertFalse($validator->passes());
    }
}
