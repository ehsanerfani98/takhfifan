<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class JoinUserConversionEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $status;
    public $user;

    public function __construct($status , User $user)
    {
        $this->user = [
            'id' => $user->id,
            'name' => $user->document
                ? trim($user->document->first_name . ' ' . $user->document->last_name)
                : ($user->email ?? $user->phone),
            'is_online' => $user->is_online,
        ];
        $this->status = $status;
    }

    public function broadcastOn()
    {
        return new Channel('user.join');
    }

    public function broadcastAs()
    {
        return 'user.is.join';
    }
}
