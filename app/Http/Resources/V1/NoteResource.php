<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NoteResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'text'           => $this->text,
            'created_by'     => new EmployeeDetailResource($this->createdBy),
            'created_at'     => $this->created_at->format('Y-m-d h:i A'),
        ];
    }
}
