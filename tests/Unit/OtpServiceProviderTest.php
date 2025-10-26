<?php

namespace Blamodex\Otp\Tests\Unit;

use Blamodex\Otp\Tests\TestCase;
use Blamodex\Otp\Validators\OtpValidator;

class OtpServiceProviderTest extends TestCase
{
    public function test_validator_binding(): void
    {
        $validator = new OtpValidator('123456');

        $this->assertTrue($validator->passes());
    }

    public function test_config_is_loaded(): void
    {
        $this->assertNotNull(config('blamodex.otp'));
    }
}