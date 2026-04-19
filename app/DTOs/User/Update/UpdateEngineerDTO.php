<?php

namespace App\DTOs\User\Update;

class UpdateEngineerDTO
{
    public function __construct(
        public ?string $specialization = null,
        public ?int $experience_years = null,
    ) {}

    public static function fromRequest(array $request): self
    {
        return new self(
            specialization: $request['specialization'] ?? null,
            experience_years: $request['experience_years'] ?? null
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'specialization'   => $this->specialization,
            'experience_years' => $this->experience_years,
        ], fn($value) => !is_null($value));
    }
}
