<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EngineerDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'account' => new UserResource($this),
            'additional_info' => [
                'engineer_id'       => $this->engineer->id,
                'specialization'    => $this->engineer->specialization,
                'experience_years'  => $this->engineer->experience_years,
            ],
        ];
    }
}
