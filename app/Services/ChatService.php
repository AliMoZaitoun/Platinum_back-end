<?php

namespace App\Services;

use App\DAO\ChatRoomDAO;
use App\DAO\MessageDAO;
use App\Events\V1\MessageSent;
use App\Models\Message;

class ChatService
{
    public function __construct(
        protected ChatRoomDAO $chatRoomDAO,
        protected MessageDAO $messageDAO
    ) {}

    public function sendMessage(array $data, $sender): Message
    {
        $data['sender_id'] = $sender->id;
        $data['sender_type'] = get_class($sender);

        $message = $this->messageDAO->create($data);

        broadcast(new MessageSent($message))->toOthers();

        return $message;
    }
}
