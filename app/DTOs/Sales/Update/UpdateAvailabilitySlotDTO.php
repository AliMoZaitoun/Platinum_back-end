<?php

namespace App\DTOs\Sales\Update;

class UpdateAvailabilitySlotDTO
{
    public function __construct(
        public ?int $employee_id,
        public ?string $start_time,
        public ?string $end_time,
        public ?string $batch_id,
        public ?string $status
    ) {}

    public static function fromRequest(array $request)
    {
        return new self(
            employee_id: $request['employee_id'] ?? null,
            start_time: $request['start_time'] ?? null,
            end_time: $request['end_time'] ?? null,
            batch_id: $request['batch_id'] ?? null,
            status: $request['status'] ?? null
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'employee_id'    => $this->employee_id,
            'start_time' => $this->start_time,
            'end_time'  => $this->end_time,
            'batch_id'  => $this->batch_id,
            'status'     => $this->status
        ], fn($value) => !is_null($value));
    }
}
