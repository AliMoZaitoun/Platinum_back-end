<?php

namespace App\Http\Resources\V1;

use App\Http\Resources\V1\RealEstate\UnitResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'client'       => new ClientDetailResource($this->whenLoaded('client')),
            'unit'         => new UnitResource($this->whenLoaded('unit')),
            'status'       => $this->status,
            'created_at'   => $this->created_at->format('Y-m-d h:i A'),
            'updated_at'   => $this->updated_at->format('Y-m-d h:i A'),
        ];
    }
}
