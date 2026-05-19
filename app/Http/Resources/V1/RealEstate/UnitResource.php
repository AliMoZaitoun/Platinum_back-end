<?php

namespace App\Http\Resources\V1\RealEstate;

use App\Http\Resources\V1\MediaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UnitResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'building_id'  => $this->building_id,
            'unit_number'  => $this->unit_number,
            'description'     => $this->description,
            'type'         => $this->type,
            'floor'        => $this->floor,
            'area'         => $this->area,
            'rooms_count'  => $this->rooms_count,
            'price'        => (float) $this->price,
            'status'       => $this->status,
            'location'     => new LocationResource($this->getLocationAttribute),
            'building'     => new BuildingResource($this->whenLoaded('building')),

            'created_at'   => $this->created_at->format('Y-m-d H:i'),
            'attachments'   => MediaResource::collection($this->whenLoaded('attachments')),
        ];
    }
}
