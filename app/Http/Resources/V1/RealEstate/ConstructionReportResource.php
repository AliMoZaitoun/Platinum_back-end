<?php

namespace App\Http\Resources\V1\RealEstate;

use App\Http\Resources\V1\EngineerDetailResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConstructionReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
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
                'report_date' => $this->report_date->format('Y-m-d'),
            ],

            'content' => [
                'description' => $this->description,
                'notes' => $this->notes ?? 'No additional notes',
            ],

            'relationships' => [
                'project' => new ProjectResource($this->whenLoaded('project')),
                'engineer' => new EngineerDetailResource($this->whenLoaded('engineer')),
            ],

            'attachments' => $this->formatAttachments(),

            'timestamps' => [
                'created_at' => $this->created_at->toDateTimeString(),
                'updated_at' => $this->updated_at->toDateTimeString(),
            ],
        ];
    }

    private function formatAttachments(): array
    {
        if (!$this->attachments) {
            return [];
        }

        return collect($this->attachments)->map(function ($path) {
            return [
                'file_name' => basename($path),
                'url' => asset('storage/' . $path),
                'extension' => pathinfo($path, PATHINFO_EXTENSION),
            ];
        })->toArray();
    }
}
