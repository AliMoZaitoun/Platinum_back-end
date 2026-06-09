<?php

namespace App\DAO;

use App\Models\Message;
use Illuminate\Pagination\LengthAwarePaginator;

class MessageDAO
{
    public function create(array $data): Message
    {
        return Message::create([
            'chat_room_id' => $data['chat_room_id'],
            'sender_id'    => $data['sender_id'],
            'sender_type'  => $data['sender_type'],
            'content' => $data['content'],
        ]);
    }

    public function getMessagesByRoomId(int $chatRoomId, int $perPage = 20): LengthAwarePaginator
    {
        return Message::where('chat_room_id', $chatRoomId)
            ->latest()
            ->paginate($perPage);
    }
}
