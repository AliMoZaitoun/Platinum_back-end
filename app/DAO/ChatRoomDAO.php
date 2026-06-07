<?php

namespace App\DAO;

use App\Models\ChatRoom;

class ChatRoomDAO
{
    public function findOrCreateOpenRoom(int $clientId): ChatRoom
    {
        return ChatRoom::firstOrCreate([
            'client_id' => $clientId,
            'status'    => 'open',
        ]);
    }

    public function findById(int $id): ?ChatRoom
    {
        return ChatRoom::find($id);
    }
}
