<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'account' => new UserResource($this),
            'additional_info' => [
                'client_id'     => $this->client->id,
                'birth_date'    => $this->client->birth_date,
                'job_title'     => $this->client->job_title,
                'social_status' => $this->client->social_status,
                'national_id'   => $this->client->national_id
            ],
        ];
    }
}
