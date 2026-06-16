<?php

namespace App\Broadcasting\V1;

use App\Models\User;
use App\Services\ChatService;

class ChatRoomChannel
{
    public function __construct(private ChatService $chatService) {}
    

    public function join(User $user, int $chatRoomId): bool
    {
        return true;
        return $this->chatService->authorizeRoomAccess($user->sender->id, $chatRoomId);
    }
}
