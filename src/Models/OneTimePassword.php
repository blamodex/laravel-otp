<?php

namespace Blamodex\Otp\Models;

use Blamodex\Otp\Contracts\OneTimePasswordableInterface;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class OneTimePassword extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'one_time_passwordable_id',
        'one_time_passwordable_type',
        'password_hash',
        'expired_at',
        'used_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'expired_at' => 'datetime',
            'used_at' => 'datetime',
        ];
    }

    /**
     * Return if the password attempt is valid
     *
     * @return bool
     */
    public function isValid($attempt): bool
    {
        return password_verify($attempt, $this->password_hash);
    }

    /**
     * Mark the OTP as used by setting the used_at timestamp.
     *
     * @return void
     */
    public function markAsUsed(): void
    {
        $this->used_at = now();
        $this->save();
    }

    /**
     * Expire all active OTPs for the given model.
     *
     * @return void
     */
    public static function expireAllFor(OneTimePasswordableInterface $model): void
    {
        static::query()
            ->where('one_time_passwordable_id', $model->getKey())
            ->where('one_time_passwordable_type', get_class($model))
            ->whereNull('used_at')
            ->whereNull('expired_at')
            ->update(['expired_at' => now()]);
    }

    /**
     * Retrieve the most recent (optionally expired) OTP for the given model.
     *
     * @return OneTimePassword|null
     */
    public static function getCurrentFor(
        OneTimePasswordableInterface $model,
        bool $withExpired = false
    ): ?OneTimePassword {
        $query = static::query()
            ->where('one_time_passwordable_id', $model->getKey())
            ->where('one_time_passwordable_type', get_class($model))
            ->whereNull('used_at')
            ->whereNull('deleted_at')
            ->orderByDesc('id');

        if (!$withExpired) {
            $query->where('expired_at', '>', now()->format('Y-m-d H:i:s'));
        }

        return $query->first();
    }

    /**
     * Laravel model booting hook.
     *
     * @return void
     */
    protected static function booted()
    {
        // Optionally add model event bindings here
    }
}
