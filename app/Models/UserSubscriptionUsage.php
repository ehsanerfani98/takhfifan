<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSubscriptionUsage extends Model
{

    protected $fillable = ['user_id', 'subscription_id', 'used_services', 'user_subscription_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function userSubscription()
    {
        return $this->belongsTo(UserSubscription::class, 'user_subscription_id');
    }

}
