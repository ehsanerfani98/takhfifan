<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['user_id', 'subscription_id', 'starts_at', 'ends_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function usage()
    {
        return $this->hasOne(UserSubscriptionUsage::class);
    }


}
