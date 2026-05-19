<?php

namespace App\Http\Resources\V1\RealEstate;

use App\Http\Resources\V1\MediaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'name'           => $this->name,
            'description'    => $this->description,
            'location'       => new LocationResource($this->whenLoaded('location')),
            'coordinates'    => [
                'latitude'   => $this->latitude,
                'longitude'  => $this->longitude,
                'radius'     => $this->radius_meters,
            ],
            'status'         => $this->status,
            'buildings'      => BuildingResource::collection($this->whenLoaded('buildings')),
            'start_date'     => $this->start_date,
            'end_date'       => $this?->end_date,
            'created_at'     => $this->created_at->format('Y-m-d h:i A'),

            'attachments'   => MediaResource::collection($this->whenLoaded('attachments')),
        ];
    }
}
