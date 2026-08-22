<?php

namespace App\Http\Resources\V1\Core;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityLogResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'description'  => $this->description,
            'subject_type' => class_basename($this->subject_type),
            'subject_id'   => $this->subject_id,
            'causer'       => $this->causer ? $this->causer->name : 'System',
            'attribute_changes' => $this->attribute_changes,
            'created_at'   => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
