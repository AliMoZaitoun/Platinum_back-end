<?php

namespace App\Services;

use App\DAO\MessageDAO;
use App\Events\V1\MessageSent;

class MessageService
{
    public function __construct(
        private MessageDAO $messageDAO
    ) {}

    public function sendMessage(array $data, int $senderId, string $senderType)
    {
        $data['sender_id']   = $senderId;
        $data['sender_type'] = $senderType;

        $message = $this->messageDAO->create($data);

        return $message;
    }

    public function getRoomMessagesArchive(int $chatRoomId, int $perPage = 20)
    {
        return $this->messageDAO->getMessagesByRoomId($chatRoomId, $perPage);
    }
}
