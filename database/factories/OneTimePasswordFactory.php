<?php

namespace Blamodex\Otp\Database\Factories;

use Blamodex\Otp\Models\OneTimePassword;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Blamodex\Otp\Models\OneTimePassword>
 */
class OneTimePasswordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        ];
    }
}
