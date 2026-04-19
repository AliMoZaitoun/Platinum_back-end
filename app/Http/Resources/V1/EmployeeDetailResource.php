<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'account' => new UserResource($this),
            'additional_info' => [
                'employee_id'       => $this->employee->id,
                'position'          => $this->employee->position
            ],
        ];
    }
}
