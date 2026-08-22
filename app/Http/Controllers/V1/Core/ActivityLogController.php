<?php

namespace App\Http\Controllers\V1\Core;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Core\ActivityLogResource;
use App\Services\Core\ActivityLogService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    use ResponseTrait;

    public function __construct(
        private ActivityLogService $activityLogService
    ) {}

    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 15);
        $logs = $this->activityLogService->getAllLogs($perPage);

        return $this->successCollection($logs, ActivityLogResource::class);
    }

    public function show(int $id)
    {
        $log = $this->activityLogService->getLogById($id);

        return $this->useResource($log, ActivityLogResource::class);
    }

    public function subjectLogs(Request $request)
    {
        $request->validate([
            'subject_type' => 'required|string',
            'subject_id'   => 'required|integer',
        ]);

        $perPage = $request->query('per_page', 15);
        $logs = $this->activityLogService->getSubjectLogs(
            $request->query('subject_type'),
            $request->query('subject_id'),
            $perPage
        );

        return $this->successCollection($logs, ActivityLogResource::class);
    }
}
