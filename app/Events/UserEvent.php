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

class UserEvent implements ShouldBroadcast {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public User $user, public $data) {}

    public function broadcastOn(): array {
        return [new PrivateChannel("App.User.{$this->user->id}")];
    }

    public function broadcastWith(): array {
        return ['data' => $this->data];
    }

    public function broadcastAs(): string {
        return 'user.notification';
    }
}
