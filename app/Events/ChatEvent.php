<?php

namespace App\Events;

use Auth;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Models\Conversation;

class ChatEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $room_id;
    public $user;
    public $reciver_id;

    public function __construct($message, $room_id, $user, $reciver_id)
    {
        $this->reciver_id = $reciver_id;
        $this->room_id = $room_id;
        $this->user = [
            'id' => $user->id,
            'name' => $user->document
                ? trim($user->document->first_name . ' ' . $user->document->last_name)
                : ($user->email ?? $user->phone),
            'is_online' => true,
            'message' => $message,
            'unread_count' => getUnreadCount($user->id, $reciver_id),
        ];
    }

    public function broadcastOn()
    {
        return [
            new PresenceChannel('rooms.' . $this->room_id),
            new PrivateChannel('conversations.user.' . $this->reciver_id),
        ];
    }

    public function broadcastAs()
    {
        return 'chat.message.sent';
    }
}
