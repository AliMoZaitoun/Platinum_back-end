<?php

namespace App\Http\Resources\V1\Lottery;

use App\Http\Resources\V1\ClientDetailResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LotteryParticipantResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'lottery'        => new LotteryResource($this->whenLoaded('lottery')),
            'client'         => new ClientDetailResource($this->whenLoaded('client')),
            'entry_date'     => $this->entry_date,
            'is_winner'      => $this->is_winner,
            'created_at'     => $this->created_at->format('Y-m-d h:i A'),
        ];
    }
}
