<?php

namespace App\Http\Resources\V1\RealEstate;

use App\Http\Resources\V1\Marketing\ClientOfferResource;
use App\Http\Resources\V1\MediaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientSolutionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                  => $this->id,
            'name'                => $this->name,
            'description'         => $this->description,

            'original_price'      => (float) $this->price,
            'current_price'       => (float) $this->current_price,
            'has_active_offer'    => $this->has_active_offer,
            'discount_percentage' => (float) $this->discount_percentage,

            'created_at'          => $this->created_at?->format('Y-m-d H:i'),
            'created_from'        => $this->created_at?->diffForHumans(),

            'attachments'         => MediaResource::collection($this->whenLoaded('attachments')),
        ];
    }
}
