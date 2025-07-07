<?php

namespace Blamodex\Otp;

use Illuminate\Support\ServiceProvider;

class OtpServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Bind services or config here
        $this->mergeConfigFrom(__DIR__ . '/config/otp.php', 'blamodex.otp');
    }

    public function boot()
    {
        // Load routes, views, migrations, etc.
        $this->publishes([
            __DIR__ . '/config/otp.php' => config_path('otp.php'),
        ], 'config');

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}