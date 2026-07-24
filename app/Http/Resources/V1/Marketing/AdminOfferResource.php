<?php

namespace App\Http\Resources\V1\Marketing;

use App\Http\Resources\V1\EmployeeDetailResource;
use App\Http\Resources\V1\RealEstate\UnitResource;
use App\Http\Resources\V1\RealEstate\SolutionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminOfferResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $now = now();

        $isCurrentlyActive = (bool) $this->status
            && $this->start_date <= $now
            && ($this->end_date === null || $this->end_date >= $now);

        return [
            'id'                  => $this->id,
            'advertisement_id'    => $this->advertisement_id,

            'item'                => $this->whenLoaded('offerable', function () {
                if ($this->offerable instanceof \App\Models\RealEstate\Unit) {
                    return new UnitResource($this->offerable);
                }
                if ($this->offerable instanceof \App\Models\RealEstate\Solution) {
                    return new SolutionResource($this->offerable);
                }
                return null;
            }),

            'discount_percentage' => (float) $this->discount_percentage,
            'old_price'           => (float) $this->old_price,
            'new_price'           => (float) $this->new_price,

            'start_date'          => $this->start_date?->format('Y-m-d H:i:s'),
            'end_date'            => $this->end_date?->format('Y-m-d H:i:s'),

            'status'              => (bool) $this->status,
            'is_active'           => $isCurrentlyActive,

            'created_by'          => new EmployeeDetailResource($this->whenLoaded('createdBy')),
            'created_at'          => $this->created_at?->format('Y-m-d H:i'),
        ];
    }
}
