<?php

namespace App\Http\Resources\V1\Sales;

use App\DAO\UserDAO;
use App\Http\Resources\V1\OrderResource;
use App\Http\Resources\V1\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id'    => $this->id,
            'order' => new OrderResource($this->whenLoaded('order')),
            'slot'  => new AvailableSlotResource($this->whenLoaded('slot')),
            'created_by' => new UserResource($this->whenLoaded('createdBy')),

            'created_at'     => $this->created_at->format('Y-m-d h:i A'),
        ];
    }
}
