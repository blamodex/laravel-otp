<?php

namespace Blamodex\Otp\Tests\Unit;

use Blamodex\Otp\Tests\TestCase;
use Blamodex\Otp\Validators\OtpValidator;

class OtpServiceProviderTest extends TestCase
{
    public function test_validator_binding(): void
    {
        $validator = app()->makeWith('OtpValidator', [
            'one_time_password' => '123456'
        ]);

        $this->assertInstanceOf(OtpValidator::class, $validator);
    }

    public function test_config_is_loaded(): void
    {
        $this->assertNotNull(config('blamodex.otp'));
    }
}