<?php

use App\Models\ChatRoom;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chat.{chatRoomId}', function ($user, int $chatRoomId) {
    $room = ChatRoom::find($chatRoomId);

    if (!$room) {
        return false;
    }

    return $user->id === $room->client_id || $user->id === $room->employee_id;
});
