<?php

namespace App\DAO\Core;

use Spatie\Activitylog\Models\Activity;
use Illuminate\Pagination\LengthAwarePaginator;

class ActivityLogDAO
{
    public function getAll(int $perPage = 15): LengthAwarePaginator
    {
        return Activity::with('causer')->latest()->paginate($perPage);
    }

    public function getById(int $id): ?Activity
    {
        return Activity::with('causer')->findOrFail($id);
    }

    public function getBySubject(string $subjectType, int $subjectId, int $perPage = 15): LengthAwarePaginator
    {
        return Activity::with('causer')
            ->where('subject_type', $subjectType)
            ->where('subject_id', $subjectId)
            ->latest()
            ->paginate($perPage);
    }
}
