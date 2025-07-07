<?php

namespace Blamodex\Otp\Models;

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
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password_hash'
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

    public function generate(): string
    {
        $alphabet = config('blamodex.otp.alphabet');
        $length = config('blamodex.otp.length');
        $algorithm = config('blamodex.otp.algorithm');
        $expiry = config('blamodex.otp.expiry');

        $password = '';

        for($i = 0; $i < $length; $i++){
            $randomCharacterPosition = rand(0, strlen($alphabet) - 1);
            $passwordCharacter = substr($alphabet, $randomCharacterPosition, 1);
            $password = $password . $passwordCharacter;
        }

        $this->password_hash = password_hash($password, $algorithm);
        $this->expired_at = Carbon::now()->addSeconds($expiry);

        return $password;
    }

    public function isValid($attempt): bool
    {
        return password_verify($attempt, $this->password_hash);
    }

    public function use()
    {
        $this->used_at = Carbon::now();
        $this->save();
    }

    protected static function booted()
    {

    }
}
