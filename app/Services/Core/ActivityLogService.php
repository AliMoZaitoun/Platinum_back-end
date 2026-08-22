<?php

namespace App\Services\Core;

use App\DAO\Core\ActivityLogDAO;

class ActivityLogService
{
    public function __construct(
        private ActivityLogDAO $activityLogDAO
    ) {}

    public function getAllLogs(int $perPage = 15)
    {
        return $this->activityLogDAO->getAll($perPage);
    }

    public function getLogById(int $id)
    {
        return $this->activityLogDAO->getById($id);
    }

    public function getSubjectLogs(string $subjectType, int $subjectId, int $perPage = 15)
    {
        $fullSubjectType = "App\\Models\\" . $subjectType;
        return $this->activityLogDAO->getBySubject($fullSubjectType, $subjectId, $perPage);
    }
}
