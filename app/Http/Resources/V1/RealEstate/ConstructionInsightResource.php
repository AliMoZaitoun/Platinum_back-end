<?php

namespace App\Http\Resources\V1\RealEstate;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConstructionInsightResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                     => $this->id,
            'building_id'            => $this->building_id,
            'construction_report_id' => $this->construction_report_id,
            'phase'                  => $this->phase,
            'type'                   => is_object($this->type) ? $this->type->value : $this->type,
            'severity'               => is_object($this->severity) ? $this->severity->value : $this->severity,
            'title'                  => $this->title,
            'diagnosis'              => $this->diagnosis,
            'recommendation'         => $this->recommendation,
            'metrics'                => $this->metrics,
            'is_read'                => (bool) $this->is_read,
            'resolved_at'            => $this->resolved_at,
            'created_at'             => $this->created_at?->diffForHumans(),

            'report'                 => new ConstructionReportResource($this->whenLoaded('report')),
        ];
    }
}
