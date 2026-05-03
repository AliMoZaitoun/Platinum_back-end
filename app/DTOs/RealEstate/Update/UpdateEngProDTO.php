<?php

namespace App\DTOs\RealEstate\Create;

class UpdateEngProDTO
{
    public function __construct(
        public ?int $engineer_id,
        public ?int $project_id,
        public ?string $start_date,
        public ?string $end_date
    ) {}

    public static function fromRequest(array $request)
    {
        return new self(
            project_id: $request['project_id'] ?? null,
            engineer_id: $request['engineer_id'] ?? null,
            start_date: $request['start_date'] ?? null,
            end_date: $request['end_date'] ?? null
        );
    }

    public function toArray()
    {
        return array_filter([
            'project_id'  => $this->project_id,
            'engineer_id'  => $this->engineer_id,
            'start_date'  => $this->start_date,
            'end_date' => $this->end_date
        ], fn($value) => !is_null($value));
    }
}
