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
        $isCurrentlyActive = $this->status == 1 && $this->starts_at <= $now && $this->ends_at >= $now;

        return [
            'id'            => $this->id,
            'title'         => $this->title,
            'description'   => $this->description,

            'starts_at'     => $this->starts_at?->format('Y-m-d h:i:s A'),
            'ends_at'       => $this->ends_at?->format('Y-m-d h:i:s A'),

            'duration_days' => $this->duration_days,

            'is_active'     => $isCurrentlyActive,

            'attachments'   => MediaResource::collection($this->whenLoaded('attachments')),
        ];
    }
}
