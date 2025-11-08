<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasPermissions, HasRoles, HasUuids;

    protected $casts = [
        'is_online' => 'boolean',
    ];

    protected $fillable = [
        "name",
        "email",
        "password",
        "phone",
        "is_online",
        "device_token"
    ];

    public function document()
    {
        return $this->hasOne(UserDocument::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(UserSubscription::class);
    }

    public function services()
    {
        return $this->hasMany(UserService::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function hasActiveSubscription(): bool
    {
        return $this->subscriptions()
            ->where('ends_at', '>', now())
            ->whereHas('payment', function ($query) {
                $query->where('status', 'paid');
            })
            ->exists();
    }

    public function roleObjects()
    {
        return $this->belongsToMany(Role::class, 'model_has_roles', 'model_id', 'role_id')
            ->where('model_type', self::class);
    }

    public function serviceRequests()
    {
        return $this->hasMany(ServiceRequest::class);
    }

    public function conversationsAsUser()
    {
        return $this->hasMany(Conversation::class, 'user_id');
    }

    public function conversationsAsAdvisor()
    {
        return $this->hasMany(Conversation::class, 'advisor_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function conversationStatuses()
    {
        return $this->hasMany(ConversationUserStatus::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
