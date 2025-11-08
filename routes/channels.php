<?php

use App\Models\Conversation;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });


// Broadcast::channel('user.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });


// Broadcast::channel('rooms.{room_id}', function ($user, $room_id) {
//     $conversation = Conversation::find($room_id);
//     if (!$conversation) {
//         return false;
//     }
//     return $user->id === $conversation->user_id || $user->id === $conversation->advisor_id;
// });

Broadcast::channel('rooms.{room_id}', function ($user, $room_id) {
    $conversation = Conversation::find($room_id);

    if (!$conversation) return false;

    if ($user->id === $conversation->user_id || $user->id === $conversation->advisor_id) {
        return [
            'id' => $user->id,
            'name' => $user->document
                ? trim($user->document->first_name . ' ' . $user->document->last_name)
                : ($user->email ?? $user->phone),
        ];
    }

    return false;
});

Broadcast::channel('conversations.user.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


Broadcast::channel('public-updates', function () {
    return true;
});


Broadcast::channel('App.User.{id}', function ($user, $id) {
    return $user->id === $id;
});

Broadcast::channel('online.advisors', function ($user) {
    return $user->hasRole('advisor')
        ? ['id' => $user->id]
        : false;
});

Broadcast::channel('online.users', function ($user) {
    return $user->hasRole('User')
        ? ['id' => $user->id]
        : false;
});

Broadcast::channel('join.room', function ($user) {
    return $user->hasRole('User')
        ? ['id' => $user->id]
        : false;
});

Broadcast::channel('advisors.status', function () {
    return true;
});