<?php

namespace App\Http\Resources\V1\Marketing;

use App\Http\Resources\V1\MediaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminAdvertisementResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'title'         => $this->title,
            'description'   => $this->description,
            'status'        => $this->status,
            'starts_at'     => $this->starts_at?->format('Y-m-d H:i:s'),
            'ends_at'       => $this->ends_at?->format('Y-m-d H:i:s'),
            'duration_days' => $this->duration_days,

            'attachments'   => MediaResource::collection($this->attachments),

            'created_by'    => $this?->created_by,
            'created_at'    => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at'    => $this->updated_at?->format('Y-m-d H:i:s'),
            'is_deleted'    => $this->deleted_at ? true : false,
        ];
    }
}
