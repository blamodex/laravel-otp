<?php

namespace Blamodex\Otp\Models;

use Blamodex\Otp\Contracts\OneTimePasswordableInterface;
use Blamodex\Otp\Events\OneTimePasswordUsed;
use Illuminate\Database\Eloquent\Model;

/**
 * The OneTimePassword model.
 *
 * @property int $id
 * @property int $one_time_passwordable_id
 * @property string $one_time_passwordable_type
 * @property string $password_hash
 * @property \Illuminate\Support\Carbon $expired_at
 * @property \Illuminate\Support\Carbon $used_at
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
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
     * @param string $attempt The password attempt to validate.
     * @return bool
     */
    public function isValid(string $attempt): bool
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

        event(new OneTimePasswordUsed($this));
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
            ->where('one_time_passwordable_type', $model->getMorphClass())
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
            ->where('one_time_passwordable_type', $model->getMorphClass())
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
