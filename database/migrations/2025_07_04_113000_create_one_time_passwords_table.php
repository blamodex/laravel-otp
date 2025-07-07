<?php

use Blamodex\Otp\Database\Migrations;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('one_time_passwords', function (Blueprint $table) {
            $table->id();
            $table->string('password_hash');

            // Polymorphic relationship
            $table->unsignedBigInteger('one_time_passwordable_id');
            $table->string('one_time_passwordable_type');

            // Tracking
            $table->dateTime('used_at')->nullable();
            $table->dateTime('expired_at')->nullable();

            // Standard timestamps + soft deletes
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index(['one_time_passwordable_id', 'one_time_passwordable_type'], 'otp_morph_index');
            $table->index('expired_at');
            $table->index('used_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('one_time_passwords');
    }
};