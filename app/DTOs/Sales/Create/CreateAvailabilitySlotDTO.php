<?php

namespace App\DTOs\Sales\Create;

class CreateAvailabilitySlotDTO
{
    public function __construct(
        public int $employee_id,
        public string $start_time,
        public string $end_time,
        public string $batch_id,
        public string $status
    ) {}

    public static function fromRequest(array $request)
    {
        return new self(
            employee_id: $request['employee_id'],
            start_time: $request['start_time'],
            end_time: $request['end_time'],
            batch_id: $request['batch_id'],
            status: $request['status']
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'employee_id'    => $this->employee_id,
            'start_time'     => new \DateTime($this->start_time),
            'end_time'       => new \DateTime($this->end_time),
            'batch_id'       => $this->batch_id,
            'status'         => $this->status
        ], fn($value) => !is_null($value));
    }
}
