<?php

namespace App\Events;

use App\Models\User;
use Auth;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class OnlineEvent implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $advisor;

    public function __construct(User $user)
    {
        $this->advisor = [
            'id' => $user->id,
            'name' => $user->document
                ? trim($user->document->first_name . ' ' . $user->document->last_name)
                : ($user->email ?? $user->phone),
            'is_online' => $user->is_online,
        ];

    }

    public function broadcastOn()
    {
        return new Channel('advisors.status');
    }

    public function broadcastAs()
    {
        return 'advisor.status.changed';
    }
}
