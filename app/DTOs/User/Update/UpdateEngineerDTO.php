<?php

namespace App\DTOs\User\Update;

class UpdateEngineerDTO
{
    public function __construct(
        public ?int $id = null,
        public ?int $user_id = null,
        public ?string $specialization = null,
        public ?int $experience_years = null,
    ) {}
}
