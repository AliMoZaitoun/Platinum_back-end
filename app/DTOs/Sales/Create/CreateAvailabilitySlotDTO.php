<?php

namespace App\DTOs\Sales\Create;

use Carbon\Carbon;
use Ramsey\Uuid\Type\Time;

class CreateAvailabilitySlotDTO
{
    public function __construct(
        public ?int $employee_id,
        public string $start_time,
        public string $end_time,
        public ?string $batch_id = null,
        public array $generated_slots = []
    ) {}

    public static function fromRequest(array $request)
    {
        return new self(
            employee_id: $request['employee_id'] ?? null,
            start_time: $request['start_time'],
            end_time: $request['end_time'],
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'employee_id'    => $this->employee_id,
            'start_time'     => $this->start_time,
            'end_time'       => $this->end_time,
            'batch_id'       => $this->batch_id,
        ], fn($value) => !is_null($value));
    }
}
