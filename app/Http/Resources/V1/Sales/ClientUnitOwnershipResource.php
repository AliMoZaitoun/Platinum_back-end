<?php

namespace App\Http\Resources\V1\Sales;

use App\Http\Resources\V1\ClientDetailResource;
use App\Http\Resources\V1\MediaResource;
use App\Http\Resources\V1\RealEstate\ClientUnitResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientUnitOwnershipResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'unit'              => new ClientUnitResource($this->whenLoaded('unit')),
            'purchase_price'    => (float) $this->purchase_price,
            'status'            => $this->status,
            'owned_at'          => $this->owned_at,
            'created_at'        => $this->created_at->format('Y-m-d H:i'),
            'attachments'       => MediaResource::collection($this->whenLoaded('attachments')),
        ];
    }
}
