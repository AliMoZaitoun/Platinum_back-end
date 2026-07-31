<?php

namespace App\Http\Resources\V1\Engineer;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApartmentDesignSuggestionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        // إذا مررت Array بدلاً من Model
        if (is_array($this->resource)) {
            $model = $this->resource['suggestion'];
            return [
                'uuid'             => $model->uuid,
                'building_id'      => $model->building_id,
                'apartment_number' => $model->apartment_number,
                'style'            => $model->design_style,
                'prompt'           => $model->user_prompt,
                'generated_images' => $model->generated_image_urls,
                'main_image_url'   => $model->generated_image_urls[0] ?? null,
                'layout_breakdown' => $this->resource['layout_breakdown'] ?? [],
                'created_at'       => $model->created_at?->toIso8601String(),
            ];
        }

        return [
            'uuid'             => $this->uuid,
            'building_id'      => $this->building_id,
            'apartment_number' => $this->apartment_number,
            'style'            => $this->design_style,
            'prompt'           => $this->user_prompt,
            'generated_images' => $this->generated_image_urls,
            'main_image_url'   => $this->generated_image_urls[0] ?? null,
            'created_at'       => $this->created_at?->toIso8601String(),
        ];
    }
}
