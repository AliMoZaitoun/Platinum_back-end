<?php

namespace App\Http\Resources\V1\Engineer;

use App\Http\Resources\V1\RealEstate\UnitResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApartmentDesignSuggestionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        if (is_array($this->resource)) {
            $model = $this->resource['suggestion'];
            return [
                'id'               => $model->id,
                'uuid'             => $model->uuid,
                'unit'             => new UnitResource($model->whenLoaded('unit')),
                'style'            => $model->design_style,
                'prompt'           => $model->user_prompt,
                'generated_images' => $model->generated_image_urls,
                'main_image_url'   => $model->generated_image_urls[0] ?? null,
                'layout_breakdown' => $model->resource['layout_breakdown'] ?? [],
                'is_published'     => $model->is_published,
                'created_at'       => $model->created_at?->toIso8601String(),
            ];
        }

        return [
            'id'               => $this->id,
            'uuid'             => $this->uuid,
            'unit'             => new UnitResource($this->whenLoaded('unit')),
            'style'            => $this->design_style,
            'prompt'           => $this->user_prompt,
            'generated_images' => $this->generated_image_urls,
            'main_image_url'   => $this->generated_image_urls[0] ?? null,
            'is_published'     => $this->is_published,
            'created_at'       => $this->created_at?->toIso8601String(),
        ];
    }
}
