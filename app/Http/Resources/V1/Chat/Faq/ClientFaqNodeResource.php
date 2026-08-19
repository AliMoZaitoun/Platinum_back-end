<?php

namespace App\Http\Resources\V1\Chat\Faq;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientFaqNodeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'      => $this->id,
            'title'   => $this->title,
            'content' => $this->content,
            'type'    => $this->type,

            'children' => ClientFaqNodeResource::collection($this->whenLoaded('children')),
        ];
    }
}
