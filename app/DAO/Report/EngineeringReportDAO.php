<?php

namespace App\DAO\Report;

use App\Models\Engineer\Attendance;
use App\Models\Engineer\ConstructionReport;
use App\Models\Engineer\Engineer;
use App\Models\Engineer\ProjectEngineerAllocation;
use Carbon\Carbon;

class EngineeringReportDAO
{
    public function getProjectsHealthStats(): array
    {
        $recentReports = ConstructionReport::where('report_date', '>=', Carbon::now()->subDays(30))->get();

        return [
            'on_track' => $recentReports->where('status', 'on_track')->count(),
            'delayed'  => $recentReports->where('status', 'delayed')->count(),
            'blocked'  => $recentReports->where('status', 'blocked')->count(),
            'total_issues' => $recentReports->sum('issues_count'),
        ];
    }

    public function getEngineersAllocationStats(): array
    {
        $totalEngineers = Engineer::count();
        $activeAllocations = ProjectEngineerAllocation::where(function ($q) {
            $q->whereNull('end_date')->orWhere('end_date', '>=', Carbon::today());
        })->distinct('engineer_id')->count('engineer_id');

        return [
            'total'     => $totalEngineers,
            'allocated' => $activeAllocations,
            'available' => $totalEngineers - $activeAllocations,
        ];
    }

    public function getSiteAttendanceStats(): array
    {
        $todayAttendances = Attendance::whereDate('checked_in_at', Carbon::today())->get();

        return [
            'checked_in_today' => $todayAttendances->count(),
            'avg_hours_week'   => Attendance::where('checked_in_at', '>=', Carbon::now()->startOfWeek())
                ->avg('total_hours') ?? 0,
        ];
    }
}
