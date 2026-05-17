<?php

namespace App\Http\Resources\V1\RealEstate;

use App\Http\Resources\V1\ClientDetailResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FavoriteResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'client'       => new ClientDetailResource($this->whenLoaded('client')),
            'unit'         => new ClientUnitResource($this->whenLoaded('unit')),
            'created_at'   => $this->created_at->format('Y-m-d h:i A')
        ];
    }
}
