<?php

namespace App\Http\Resources\V1\Sales;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ComplaintTypeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'    => $this->id,
            'title' => $this->title,

            'created_at'     => $this->created_at->format('Y-m-d h:i A'),
        ];
    }
}
