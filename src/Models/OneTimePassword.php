<?php

namespace Blamodex\Otp\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OneTimePassword extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'password_hash',
        'expired_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'expired_at' => 'datetime'
        ];
    }

    public function generatePassword(){
        $alphabet = config('blamodex.otp.alphabet');
        $length = config('blamodex.otp.length');
        $password = '';

        for($i = 0; $i < $length; $i++){
            $randomCharacterPosition = rand(0, strlen($alphabet) - 1);
            $passwordCharacter = substr($alphabet, $randomCharacterPosition, 1);
            $password = $password . $passwordCharacter;
        }

        return $password;
    }

    public function isValid($attempt) {
        //GET THE USER

        //GET THE USER'S ACTIVE ONE TIME PASSWORD

        $activePassword = null;

        return password_verify($attempt, $activePassword->password_hash);
    }

    protected static function booted()
    {

    }
}
