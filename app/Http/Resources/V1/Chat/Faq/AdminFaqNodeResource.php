<?php

namespace App\Http\Resources\V1\Chat\Faq;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminFaqNodeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'parent_id'  => $this->parent_id,
            'title'      => $this->title,
            'content'    => $this->content,
            'type'       => $this->type,
            'sort_order' => (int) $this->sort_order,
            'children'   => AdminFaqNodeResource::collection($this->whenLoaded('children')),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
