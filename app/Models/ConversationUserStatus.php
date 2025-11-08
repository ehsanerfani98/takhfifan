<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ConversationUserStatus extends Model
{
    use HasUuids;

    protected $fillable = [
        'conversation_id',
        'user_id',
        'in_room',
    ];

    protected $casts = [
        'in_room' => 'boolean',
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
