<?php

namespace App\Http\Resources\V1\Marketing;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdvertismentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'title'         => $this->title,
            'description'   => $this->description,
            'status'        => $this->status,
            'duration'      => $this->duration,
            'end_date'      => $this->end_date,
            'created_by'    => $this->created_by
        ];
    }
}
