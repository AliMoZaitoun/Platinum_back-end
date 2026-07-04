<?php

namespace App\Http\Resources\V1\Marketing;

use App\Http\Resources\V1\RealEstate\ClientUnitResource;
use App\Http\Resources\V1\RealEstate\SolutionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientOfferResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $now = now();
        $isCurrentlyActive = $this->status == 1 && $this->starts_at <= $now && $this->ends_at >= $now;

        return [
            'id'    =>     $this->id,

            'item'                => $this->whenRelationLoaded('offerable', function () {
                if ($this->offerable instanceof \App\Models\RealEstate\Unit) {
                    return new ClientUnitResource($this->offerable);
                }
                if ($this->offerable instanceof \App\Models\RealEstate\Solution) {
                    return new SolutionResource($this->offerable);
                }
                return null;
            }),

            'discount_percentage'   => $this->discount_percentage,
            'old_price'     => $this->old_price,
            'new_price'     => $this->new_price,

            'starts_at'     => $this->starts_at?->format('Y-m-d h:i:s A'),
            'ends_at'       => $this->ends_at?->format('Y-m-d h:i:s A'),

            'duration_days' => $this->duration_days,

            'is_active'     => $isCurrentlyActive,

            'created_at'     => $this->created_at->format('Y-m-d h:i A'),
        ];
    }
}
