<?php

namespace App\Http\Resources\V1\Engineer;

use App\Http\Resources\V1\EngineerDetailResource;
use App\Http\Resources\V1\RealEstate\ProjectResource;
use App\Http\Resources\V1\RealEstate\BuildingResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectEngineerAllocationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $isProjectWide = is_null($this->building_id);

        return [
            'id' => $this->id,
            'allocation_type' => $isProjectWide ? 'project_wide' : 'specific_building',

            'project_id' => $this->project_id,
            'building_id' => $this->building_id,

            'project_name' => $this->project?->name,
            'building_number' => $this->building?->building_number,

            'latitude' => (float) ($this->building_id ? $this->building?->latitude : $this->project?->latitude),
            'longitude' => (float) ($this->building_id ? $this->building?->longitude : $this->project?->longitude),
            'allowed_radius' => (int) ($this->building_id ? $this->building?->radius_meters : $this->project?->radius_meters),

            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'created_at' => $this->created_at?->format('Y-m-d h:i A'),

            'project' => new ProjectResource($this->whenLoaded('project')),

            'building' => new BuildingResource($this->whenLoaded('building')),
        ];
    }
}
