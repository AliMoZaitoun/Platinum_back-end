<?php

namespace App\Http\Resources\V1\RealEstate;

use App\Http\Resources\V1\MediaResouce;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BuildingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'project_id'      => $this->project_id,
            'building_number' => $this->building_number,
            'description'     => $this->description,
            'floors_count'    => $this->floors_count,
            'location_id'     => $this->location_id,
            'status'          => $this->status,
            'project'         => new ProjectResource($this->whenLoaded('project')),
            'units'           => UnitResource::collection($this->whenLoaded('units')),

            'attachments'     => MediaResouce::collection($this->attachments),
        ];
    }
}
