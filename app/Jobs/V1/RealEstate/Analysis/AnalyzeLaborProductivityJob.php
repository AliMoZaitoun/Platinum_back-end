<?php

namespace App\Jobs\V1\RealEstate\Analysis;

use App\Models\Engineer\ConstructionReport;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AnalyzeLaborProductivityJob implements ShouldQueue
{
    use Queueable;

    public function __construct(public ConstructionReport $report) {}

    public function handle(): void
    {
        $report = $this->report;
        $reportDate = $report->report_date;

        $sevenDaysAgo = $reportDate->copy()->subDays(7)->toDateTimeString();
        $threeDaysAgo = $reportDate->copy()->subDays(3)->toDateTimeString();
        $nowStr       = $reportDate->toDateTimeString();

        $analytics = DB::table('construction_reports')
            ->where('building_id', $report->building_id)
            ->where('phase', $report->phase)
            ->whereNull('deleted_at')
            ->whereBetween('report_date', [$sevenDaysAgo, $nowStr])
            ->selectRaw("
                AVG(CASE WHEN report_date BETWEEN ? AND ? THEN manpower_count END) as past_avg_manpower,
                AVG(CASE WHEN report_date BETWEEN ? AND ? THEN daily_progress END) as past_avg_progress,
                AVG(CASE WHEN report_date > ? THEN manpower_count END) as current_avg_manpower,
                AVG(CASE WHEN report_date > ? THEN daily_progress END) as current_avg_progress
            ", [
                $sevenDaysAgo,
                $threeDaysAgo, // للـ manpower الماضي
                $sevenDaysAgo,
                $threeDaysAgo, // للـ progress الماضي
                $threeDaysAgo,                 // للـ manpower الحاضر
                $threeDaysAgo                  // للـ progress الحاضر
            ])
            ->first();

        if (!$analytics || is_null($analytics->past_avg_manpower) || is_null($analytics->current_avg_manpower)) {
            return;
        }

        // الحسابات الرياضية البسيطة
        $pastWorkerProd    = $analytics->past_avg_manpower > 0 ? ($analytics->past_avg_progress / $analytics->past_avg_manpower) : 0;
        $currentWorkerProd = $analytics->current_avg_manpower > 0 ? ($analytics->current_avg_progress / $analytics->current_avg_manpower) : 0;

        // الشروط (إذا تحقق الانحراف الكارثي)
        if (
            $analytics->current_avg_manpower > $analytics->past_avg_manpower &&
            $analytics->current_avg_progress < $analytics->past_avg_progress &&
            $currentWorkerProd <= ($pastWorkerProd * 0.70)
        ) {

            $dropPercentage = $pastWorkerProd > 0 ? round((($pastWorkerProd - $currentWorkerProd) / $pastWorkerProd) * 100, 1) : 0;

            Log::warning("⚠️ [Labor Overcrowding Alert] - Building ID: {$report->building_id}, Phase: {$report->phase}");
            Log::warning("Details: Manpower rose from " . round($analytics->past_avg_manpower, 1) . " to " . round($analytics->current_avg_manpower, 1) . " workers.");
            Log::warning("Impact: Daily progress dropped from " . round($analytics->past_avg_progress, 2) . "% to " . round($analytics->current_avg_progress, 2) . "%.");
            Log::warning("Diagnosis: Individual worker productivity collapsed by {$dropPercentage}%!");
        }
    }
}
