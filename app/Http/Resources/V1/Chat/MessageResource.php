<?php

namespace App\Http\Resources\V1\Chat;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'room_id'       => $this->chat_room_id,
            'sender_id'     => $this->sender_id,
            'sender_type'   => $this->sender_type,
            'content'       => $this->content,
            'created_at'    => $this->created_at->toDateTimeString()
        ];
    }
}
