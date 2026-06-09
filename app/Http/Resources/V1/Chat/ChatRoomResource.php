<?php

namespace App\Http\Resources\V1\Chat;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatRoomResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'client_id'      => $this->client_id,
            'employee_id'    => $this->employee_id,
            'status'        => $this->status,
            'created_at'     => $this->created_at->toDateTimeString(),
            'updated_at'     => $this->updated_at->toDateTimeString(),

            'latestMessage' => $this->relationLoaded('latestMessage') && $this->latestMessage ? [
                'content'   => $this->latestMessage->content,
                'created_at' => $this->latestMessage->created_at->toDateTimeString(),
            ] : null,
        ];
    }
}
