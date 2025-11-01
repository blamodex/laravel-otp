<?php

declare(strict_types=1);

namespace Blamodex\Otp\Events;

use Blamodex\Otp\Models\OneTimePassword;
use Illuminate\Queue\SerializesModels;

class OneTimePasswordUsed
{
    use SerializesModels;

    /**
     * The generated OTP model.
     *
     * @var OneTimePassword
     */
    public OneTimePassword $otp;

    /**
     * Create a new event instance.
     *
     * @param OneTimePassword $otp
     */
    public function __construct(OneTimePassword $otp)
    {
        $this->otp = $otp;
    }
}
