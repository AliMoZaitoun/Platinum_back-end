<?php

namespace App\DTOs\Engineering;

class CreateReportDTO
{
    public function __construct(
        public string $uuid,
        public int $project_id,
        public int $engineer_id,
        public string $phase,
        public int $completion_percentage,
        public int $daily_progress,
        public string $status,
        public int $manpower_count,
        public int $issues_count,
        public ?string $description,
        public string $report_date,
        public ?string $recorded_at
    ) {}

    public static function fromRequest(array $request): self
    {
        return new self(
            uuid: $request['uuid'],
            project_id: $request['project_id'],
            engineer_id: $request['engineer_id'],
            phase: $request['phase'],
            completion_percentage: (int) $request['completion_percentage'],
            daily_progress: (int) $request['daily_progress'],
            status: $request['status'] ?? 'on_track',
            manpower_count: (int) ($request['manpower_count'] ?? 0),
            issues_count: (int) ($request['issues_count'] ?? 0),
            description: $request['description'] ?? null,
            report_date: $request['report_date'],
            recorded_at: $request['recorded_at'] ?? null
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'uuid'                  => $this->uuid,
            'project_id'            => $this->project_id,
            'engineer_id'           => $this->engineer_id,
            'phase'                 => $this->phase,
            'completion_percentage' => $this->completion_percentage,
            'daily_progress'        => $this->daily_progress,
            'status'                => $this->status,
            'manpower_count'        => $this->manpower_count,
            'issues_count'          => $this->issues_count,
            'description'           => $this->description,
            'report_date'           => $this->report_date,
            'recorded_at'           => $this->recorded_at,
        ], fn($value) => !is_null($value));
    }
}
