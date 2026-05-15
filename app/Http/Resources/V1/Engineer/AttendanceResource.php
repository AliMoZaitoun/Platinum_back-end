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
            'check_in' => $this->check_in ? Carbon::parse($this->check_in)->format('Y-m-d H:i:s') : null,
            'check_out' => $this->check_out ? Carbon::parse($this->check_out)->format('Y-m-d H:i:s') : null,
            'status' => $this->status,
            'recorded_at' => $this->recorded_at ? Carbon::parse($this->recorded_at)->format('Y-m-d') : null,
            'is_currently_active' => is_null($this->check_out),
            'location' => [
                'check_in_lng' => $this->check_in_lng,
                'check_out_lat' => $this->check_out_lat,
                'check_out_lng' => $this->check_out_lng,
            ]
        ];
    }
}
