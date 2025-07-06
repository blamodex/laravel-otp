<?php

namespace Blamodex\Otp\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Blamodex\Otp\OtpServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            OtpServiceProvider::class,
        ];
    }

    // Optional: setup environment
    protected function defineEnvironment($app)
    {
        // $app['config']->set('your-config', 'value');
    }
}
