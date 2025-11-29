<?php

declare(strict_types=1);

namespace Blamodex\Otp\Tests\Unit;

use Blamodex\Otp\Tests\TestCase;

class OtpServiceProviderTest extends TestCase
{
    public function test_config_is_loaded(): void
    {
        $this->assertNotNull(config('blamodex.otp'));
    }
}