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

        $target = $isProjectWide ? $this->project : ($this->building ?? $this->project);

        return [
            'id'             => $this->id,
            'allocation_type' => $isProjectWide ? 'project_wide' : 'specific_building',

            'target_id'      => $isProjectWide ? $this->project_id : $this->building_id,
            'target_name'    => $target?->name,
            'latitude'       => (float) ($target?->latitude ?? $target?->latitude),
            'longitude'      => (float) ($target?->longitude ?? $target?->longitude),
            'allowed_radius' => (int) ($target?->radius_meters ?? ($isProjectWide ? 150 : 40)),

            'start_date'     => $this->start_date,
            'end_date'       => $this->end_date,
            'created_at'     => $this->created_at?->format('Y-m-d h:i A'),

            'project'        => new ProjectResource($this->whenLoaded('project')),
            'building'       => new BuildingResource($this->whenLoaded('building')),
            'engineer'       => new EngineerDetailResource($this->whenLoaded('engineer')),
        ];
    }
}
