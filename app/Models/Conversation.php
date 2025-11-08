<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasUuids;

    protected $fillable = ['user_id', 'advisor_id', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function advisor()
    {
        return $this->belongsTo(User::class, 'advisor_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function userStatuses()
    {
        return $this->hasMany(ConversationUserStatus::class);
    }
}
