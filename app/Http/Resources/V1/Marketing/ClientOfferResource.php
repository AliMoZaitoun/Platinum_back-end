<?php

namespace App\Http\Resources\V1\Marketing;

use App\Http\Resources\V1\RealEstate\ClientSolutionResource;
use App\Http\Resources\V1\RealEstate\ClientUnitResource;
use App\Http\Resources\V1\RealEstate\SolutionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientOfferResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $now = now();

        $isCurrentlyActive = (bool) $this->status
            && $this->start_date <= $now
            && ($this->end_date === null || $this->end_date >= $now);

        return [
            'id'                  => $this->id,

            'item_type'           => match ($this->offerable_type) {
                \App\Models\RealEstate\Unit::class     => 'unit',
                \App\Models\RealEstate\Solution::class => 'solution',
                default                                => 'unknown',
            },

            'item'                => $this->whenLoaded('offerable', function () {
                if ($this->offerable instanceof \App\Models\RealEstate\Unit) {
                    return new ClientUnitResource($this->offerable);
                }
                if ($this->offerable instanceof \App\Models\RealEstate\Solution) {
                    return new ClientSolutionResource($this->offerable);
                }
                return null;
            }),

            'discount_percentage' => (float) $this->discount_percentage,
            'old_price'           => (float) $this->old_price,
            'new_price'           => (float) $this->new_price,

            'start_date'          => $this->start_date?->format('Y-m-d H:i:s'),
            'end_date'            => $this->end_date?->format('Y-m-d H:i:s'),

            'is_active'           => $isCurrentlyActive,

            'created_at'          => $this->created_at?->format('Y-m-d H:i'),
        ];
    }
}
