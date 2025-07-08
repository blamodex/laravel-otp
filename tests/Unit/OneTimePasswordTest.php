<?php

namespace Blamodex\Otp\Tests\Unit;

use Blamodex\Otp\Contracts\OneTimePasswordableInterface;
use Blamodex\Otp\Models\OneTimePassword;
use Blamodex\Otp\Services\OtpGenerator;
use Blamodex\Otp\Tests\TestCase;
use Blamodex\Otp\Tests\Fixtures\DummyOtpUser;
use Illuminate\Database\Eloquent\Model;

/**
 * @covers \Blamodex\Otp\Models\OneTimePassword
 */
class OneTimePasswordTest extends TestCase
{
    /**
     * It returns true when the correct password is verified, and false otherwise.
     *
     * @test
     */
    public function test_is_valid_returns_true_for_correct_attempt()
    {
        $otp = new OneTimePassword;

        $password = app(OtpGenerator::class)->generate($otp);

        $this->assertTrue($otp->isValid($password));
        $this->assertFalse($otp->isValid('wrong'));
    }

    /**
     * It sets the 'used_at' field when marked as used.
     *
     * @test
     */
    public function test_mark_as_used_sets_used_at()
    {
        $otp = OneTimePassword::create([
            'one_time_passwordable_id' => 1,
            'one_time_passwordable_type' => DummyOtpUser::class,
            'password_hash' => 'foo',
        ]);

        $this->assertNull($otp->used_at);

        $otp->markAsUsed();
        $this->assertNotNull($otp->fresh()->used_at);
    }

    /**
     * It sets 'expired_at' on all active OTPs for a model.
     *
     * @test
     */
    public function test_expire_all_for_sets_expired_at()
    {
        $user = DummyOtpUser::create();

        OneTimePassword::create([
            'one_time_passwordable_id' => $user->id,
            'one_time_passwordable_type' => DummyOtpUser::class,
            'password_hash' => 'foo',
        ]);

        OneTimePassword::expireAllFor($user);

        $this->assertNotNull(
            OneTimePassword::first()->fresh()->expired_at
        );
    }

    /**
     * It excludes expired OTPs unless explicitly requested.
     *
     * @test
     */
    public function test_get_current_for_excludes_expired()
    {
        $user = DummyOtpUser::create();

        // Valid OTP
        $valid = OneTimePassword::create([
            'one_time_passwordable_id' => $user->id,
            'one_time_passwordable_type' => DummyOtpUser::class,
            'password_hash' => 'foo',
            'expired_at' => now()->addMinute()->format('Y-m-d H:i:s'),
        ]);

        // Expired OTP
        $expired = OneTimePassword::create([
            'one_time_passwordable_id' => $user->id,
            'one_time_passwordable_type' => DummyOtpUser::class,
            'password_hash' => 'foo',
            'expired_at' => now()->subMinute()->format('Y-m-d H:i:s'),
        ]);

        $fetched = OneTimePassword::getCurrentFor($user);
        $this->assertEquals($valid->id, $fetched->id);

        $fetchedWithExpired = OneTimePassword::getCurrentFor($user, true);
        $this->assertEquals($expired->id, $fetchedWithExpired->id);
    }
}
