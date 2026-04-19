<?php

namespace App\DTOs\User;

use Illuminate\Support\Facades\Date;

class CreateClientDTO
{
    public function __construct(
        public ?int $id,
        public ?int $user_id,
        public \DateTime $birth_date,
        public string $job_title,
        public string $social_status,
        public string $national_id
    ) {}

    public static function fromRequest(array $request): self
    {
        return new self(
            id: null,
            user_id: null,
            birth_date: new \DateTime($request['birth_date']),
            job_title: $request['job_title'],
            social_status: $request['social_status'],
            national_id: $request['national_id']
        );
    }

    public function toArray()
    {
        return [
            'user_id' => $this->user_id,
            'birth_date' => $this->birth_date,
            'job_title' => $this->job_title,
            'social_status' => $this->social_status,
            'national_id' => $this->national_id
        ];
    }
}
