<?php

namespace Blamodex\Otp\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Blamodex\Otp\Models\OneTimePassword;

trait OneTimePasswordable
{
    /**
     * Generate and store a new password.
     */
    public function generateOtp(): string
    {
        $oneTimePasswordModel = app(OneTimePassword::class);

        $oneTimePassword = $oneTimePasswordModel->generate();

        $this->expireExistingPasswords();

        $oneTimePasswordModel->one_time_passwordable_id = $this->id;
        $oneTimePasswordModel->one_time_passwordable_type = get_class($this);

        $oneTimePasswordModel->save();

        return $oneTimePassword;
    }

    /**
     * Check if a given password matches the stored one.
     */
    public function verifyOtp(string $attempt): bool
    {
        $currentPassword = $this->getCurrentOtp();

        $currentAttemptIsValid = $currentPassword->isValid($attempt);

        if($currentAttemptIsValid){
            $currentPassword->use();
        }

        return $currentAttemptIsValid;
    }

    /**
     * Check if the password is expired.
     */
    public function isCurrentOtpExpired(): bool
    {
        $currentPasswordWithExpired = $this->getCurrentOtp(true);

        return Carbon::now()->greaterThan($currentPasswordWithExpired->expired_at);
    }

    public function getCurrentOtp($withExpired = false){

        $now = Carbon::now();

        $query = OneTimePassword::where('one_time_passwordable_id', $this->id)
                ->where('one_time_passwordable_type', get_class($this))
                ->whereNull('used_at')
                ->whereNull('deleted_at')
                ->orderBy('id', 'DESC');

        if($withExpired){
            return $query->first();
        } else {
            return $query->where('expired_at', '>', $now)
                ->first();
        }
    }

    private function expireExistingPasswords(){
        OneTimePassword::where('one_time_passwordable_id', $this->id)
            ->where('one_time_passwordable_type', get_class($this))
            ->whereNull('expired_at')
            ->whereNull('deleted_at')
            ->orderBy('id', 'DESC')
            ->update(
                ['expired_at' => Carbon::now()]
            );
    }

}
