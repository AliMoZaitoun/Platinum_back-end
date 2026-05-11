<?php

namespace App\Http\Resources\V1\Core;

use App\Http\Resources\V1\EngineerDetailResource;
use App\Http\Resources\V1\RealEstate\ProjectResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EngineerProjectResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'project'     => new ProjectResource($this->whenLoaded('project')),
            'engineer'    => new EngineerDetailResource($this->whenLoaded('engineer')),
            'start_date'  => $this->start_date,
            'end_date'    => $this->end_date,
            'created_at'  => $this->created_at->format('Y-m-d h:i A'),
            // 'attachments' => 
        ];
    }
}
