<?php

namespace Blamodex\Otp\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Blamodex\Otp\OtpServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

abstract class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            OtpServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $migration = require __DIR__ . '/../database/migrations/2025_07_04_113000_create_one_time_passwords_table.php';
        $migration->up();

        \Schema::create('otp_users', function ($table) {
            $table->id();
        });
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('one_time_passwords');

        parent::tearDown();
    }
}
