<?php

namespace App\Http\Resources\V1\Resourcs;

use App\Http\Resources\V1\MediaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ComplaintResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type'  => $this->type->title,
            'title' => $this->title,
            'body' => $this->body,
            'attachments'   => new MediaResource($this->whenLoaded('attachments'))
        ];
    }
}
