<?php

namespace App\Http\Resources\V1\RealEstate;

use App\Http\Resources\V1\EngineerDetailResource;
use App\Http\Resources\V1\MediaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConstructionReportResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,

            'report_details' => [
                'phase' => $this->phase,
                'status' => $this->status,
                'completion_percentage' => (float) $this->completion_percentage,
                'daily_progress' => (float) $this->daily_progress,
                'report_date' => $this->report_date,
            ],

            'content' => [
                'description' => $this->description,
            ],

            'relationships' => [
                'project' => new ProjectResource($this->whenLoaded('project')),
                'engineer' => new EngineerDetailResource($this->whenLoaded('engineer')),
            ],

            'attachments' => MediaResource::collection($this->attachments),

            'timestamps' => [
                'recorded_at' => $this->recorded_at,
                'created_at'  => $this->created_at->format('Y-m-d h:i A'),
                'updated_at'  => $this->updated_at->format('Y-m-d h:i A'),
            ],
        ];
    }
}
