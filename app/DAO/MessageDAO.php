<?php

namespace App\DAO;

use App\Models\Message;

class MessageDAO
{
    public function create(array $data): Message
    {
        return Message::create([
            'chat_room_id' => $data['chat_room_id'],
            'sender_id'    => $data['sender_id'],
            'sender_type'  => $data['sender_type'],
            'message_text' => $data['message_text'],
        ]);
    }
}
