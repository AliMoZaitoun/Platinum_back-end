<?php

namespace App\Http\Resources\V1\Lottery;

use App\Http\Resources\V1\ClientDetailResource;
use App\Http\Resources\V1\RealEstate\UnitResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LotteryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'title'          => $this->title,
            'status'         => $this->status,

            'unit'           => new UnitResource($this->whenLoaded('unit')),
            'created_at'     => $this->created_at->format('Y-m-d h:i A'),

            'winner'         => new ClientDetailResource($this->whenLoaded('winner')),

            'rules'          => LotteryRuleResource::collection($this->whenLoaded('rules')),

            'participants'   => LotteryParticipantResource::collection($this->whenLoaded('participants'))
        ];
    }
}
