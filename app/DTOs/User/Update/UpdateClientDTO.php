<?php

namespace App\DTOs\User\Update;

use Illuminate\Support\Facades\Date;

class UpdateClientDTO
{
    public function __construct(
        public ?int $id,
        public ?int $user_id,
        public ?\DateTime $birth_date,
        public ?string $job_title,
        public ?string $social_status,
        public ?string $national_id
    ) {}
}
