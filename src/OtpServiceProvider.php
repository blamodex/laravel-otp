<?php

namespace Blamodex\Otp;

use Illuminate\Support\ServiceProvider;

/**
 * Service provider for the OTP package.
 *
 * Handles the registration and bootstrapping of package services,
 * including configuration merging and migration loading.
 */
class OtpServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * This is where bindings, singletons, and config merging should happen.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/config/otp.php', 'blamodex.otp');
    }

    /**
     * Bootstrap any package services.
     *
     * This is where you load migrations, publish configs, etc.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/config/otp.php' => config_path('otp.php'),
        ], 'config');

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}
