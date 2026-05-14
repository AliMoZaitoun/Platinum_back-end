<?php

namespace App\Http\Resources\V1\Sales;

use App\Http\Resources\V1\EmployeeDetailResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AvailableSlotResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'start_time'    => $this->start_time,
            'status'        => $this->status,
            'batch_id'      => $this->batch_id,
            'employee'      => new EmployeeDetailResource($this->whenLoaded('employee'))
        ];
    }
}
