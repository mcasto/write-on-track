<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'subscription_status',
        'subscription_ends_at',
        'trial_ends_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'subscription_ends_at' => 'datetime',
        'trial_ends_at' => 'datetime',
    ];

    public function markets()
    {
        return $this->hasMany(Market::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function stories()
    {
        return $this->hasMany(Story::class);
    }

    public function subscription()
    {
        return $this->hasOne(UserSubscription::class);
    }

    public function canCreateMarket(): bool
    {
        // Check subscription limits
        if ($this->subscription_status === 'free') {
            $marketCount = $this->markets()->count();
            $freeLimit = config('subscription.free_market_limit', 10);
            return $marketCount < $freeLimit;
        }

        return true;
    }
}
