<?php

namespace App\Http\Resources\V1\RealEstate;

use App\Http\Resources\V1\MediaResource;
use App\Http\Resources\V1\Marketing\ClientOfferResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ClientUnitResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $client = Auth::user()?->client;

        $isFavorite = false;

        if ($client) {
            $isFavorite = $client->favorites()->where('unit_id', $this->id)->exists();
        }

        return [
            'id'           => $this->id,
            'building_id'  => $this->building_id,
            'unit_number'  => $this->unit_number,
            'description'  => $this->description,
            'type'         => $this->type,
            'floor'        => $this->floor,
            'area'         => $this->area,
            'rooms_count'  => $this->rooms_count,

            'original_price'      => (float) $this->price,
            'current_price'       => (float) $this->current_price,
            'has_active_offer'    => $this->has_active_offer,
            'discount_percentage' => (float) $this->discount_percentage,

            'status'       => $this->status,
            'building'     => new BuildingResource($this->whenLoaded('building')),

            'created_at'   => $this->created_at?->format('Y-m-d H:i'),

            'is_favorite'  => $isFavorite,
            'attachments'  => MediaResource::collection($this->whenLoaded('attachments'))
        ];
    }
}
