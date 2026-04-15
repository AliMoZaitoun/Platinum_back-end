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
}
