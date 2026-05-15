<?php

namespace App\Http\Resources\V1\Engineer;

use App\Http\Resources\V1\EngineerDetailResource;
use App\Http\Resources\V1\RealEstate\ProjectResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'engineer_id' => new EngineerDetailResource($this->whenLoaded('engineer')),
            'project_id' => new ProjectResource($this->whenLoaded('project')),
            'checked_in_at' => $this->checked_in_at ? Carbon::parse($this->checked_in_at)->format('Y-m-d H:i:s') : null,
            'checked_out_at' => $this->checked_out_at ? Carbon::parse($this->checked_out_at)->format('Y-m-d H:i:s') : null,
            'is_currently_active' => is_null($this->checked_out_at),
            'location' => [
                'check_in_lat' => $this->check_in_lat,
                'check_in_lng' => $this->check_in_lng,
                'check_out_lat' => $this->check_out_lat,
                'check_out_lng' => $this->check_out_lng,
            ],
            'total_hours' => $this->total_hours
        ];
    }
}
