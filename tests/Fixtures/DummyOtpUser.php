<?php

declare(strict_types=1);

namespace Blamodex\Otp\Tests\Fixtures;

use Blamodex\Otp\Traits\OneTimePasswordable;
use Blamodex\Otp\Contracts\OneTimePasswordableInterface;
use Illuminate\Database\Eloquent\Model;

class DummyOtpUser extends Model implements OneTimePasswordableInterface
{
    use OneTimePasswordable;

    protected $table = 'otp_users';
    protected $guarded = [];
    public $timestamps = false;
}
