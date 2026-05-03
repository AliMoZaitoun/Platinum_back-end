<?php

namespace App\Http\Resources\V1;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EngineerDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $engineer = $this->resource instanceof User
            ? $this->resource->engineer
            : $this->resource;

        $user = $this->resource instanceof User
            ? $this->resource
            : $this->resource->user;

        return [
            'account' => new UserResource($user),
            'additional_info' => [
                'engineer_id'       => $engineer->id,
                'specialization'    => $engineer->specialization,
                'experience_years'  => $engineer->experience_years,
            ],
        ];
    }
}
