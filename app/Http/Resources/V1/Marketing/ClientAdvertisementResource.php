<?php

namespace App\Http\Resources\V1\Marketing;

use App\Http\Resources\V1\MediaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientAdvertisementResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $now = now();
        $isCurrentlyActive = (bool)$this->status && $this->starts_at <= $now && $this->ends_at >= $now;

        return [
            'id'            => $this->id,
            'title'         => $this->title,
            'description'   => $this->description,

            'starts_at'     => $this->starts_at?->format('Y-m-d H:i:s'),
            'ends_at'       => $this->ends_at?->format('Y-m-d H:i:s'),

            'duration_days' => $this->duration_days,
            'is_active'     => $isCurrentlyActive,

            'offers'        => ClientOfferResource::collection($this->whenLoaded('offers')),

            'attachments'   => MediaResource::collection($this->whenLoaded('attachments')),
        ];
    }
}
