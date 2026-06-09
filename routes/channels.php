<?php

use App\Broadcasting\V1\ChatRoomChannel;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function (User $user, $id) {
    return (int) $user->id === (int) $id;
}, ['guards' => ['sanctum']]);

Broadcast::channel('chat.{chatRoomId}', ChatRoomChannel::class, ['guards' => ['sanctum']]);
