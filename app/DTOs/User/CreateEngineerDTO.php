<?php

namespace App\DTOs\User;

class CreateEngineerDTO
{
    public function __construct(
        public ?int $id,
        public ?int $user_id,
        public string $specialization,
        public int $experience_years,
    ) {}

    public static function fromRequest(array $request): self
    {
        return new self(
            id: null,
            user_id: null,
            specialization: $request['specialization'],
            experience_years: $request['experience_years']
        );
    }

    public function toArray()
    {
        return [
            'user_id'           => $this->user_id,
            'specialization'    => $this->specialization,
            'experience_years'  => $this->experience_years
        ];
    }
}
