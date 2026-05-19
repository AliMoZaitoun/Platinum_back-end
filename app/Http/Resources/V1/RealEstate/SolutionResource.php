<?php

namespace App\Http\Resources\V1\RealEstate;

use App\Http\Resources\V1\MediaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SolutionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'description'   => $this->description,
            'price'         => (float) $this->price,
            'created_at'    => $this->created_at->format('Y-m-d H:i'),
            'created_from'  => $this->created_at->diffForHumans(),

            'attachments' => MediaResource::collection($this->attachments)
        ];
    }
}
