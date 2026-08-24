<?php

namespace App\Jobs\V1\RealEstate\Analysis;

use App\DAO\RealEstate\ConstructionInsightDAO;
use App\Enums\Reports\InsightSeverity;
use App\Enums\Reports\InsightType;
use App\Models\Engineer\ConstructionReport;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AnalyzeLaborProductivityJob implements ShouldQueue
{
    use Queueable;

    public function __construct(public ConstructionReport $report) {}

    public function handle(ConstructionInsightDAO $insightDAO): void
    {
        $report = $this->report;
        $reportDate = Carbon::parse($report->report_date);

        $sevenDaysAgo = $reportDate->copy()->subDays(7)->toDateTimeString();
        $threeDaysAgo = $reportDate->copy()->subDays(3)->toDateTimeString();
        $nowStr       = $reportDate->toDateTimeString();

        $analytics = DB::table('construction_reports')
            ->where('project_id', $report->project_id)
            ->when(
                is_null($report->building_id),
                fn($q) => $q->whereNull('building_id'),
                fn($q) => $q->where('building_id', $report->building_id)
            )
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
                $threeDaysAgo,
                $sevenDaysAgo,
                $threeDaysAgo,
                $threeDaysAgo,
                $threeDaysAgo
            ])
            ->first();

        if (!$analytics || is_null($analytics->past_avg_manpower) || is_null($analytics->current_avg_manpower)) {
            return;
        }

        $pastWorkerProd    = $analytics->past_avg_manpower > 0 ? ($analytics->past_avg_progress / $analytics->past_avg_manpower) : 0;
        $currentWorkerProd = $analytics->current_avg_manpower > 0 ? ($analytics->current_avg_progress / $analytics->current_avg_manpower) : 0;

        $curManpower = round($analytics->current_avg_manpower, 1);
        $curProgress = round($analytics->current_avg_progress, 2);
        $pastManpower = round($analytics->past_avg_manpower, 1);
        $pastProgress = round($analytics->past_avg_progress, 2);

        if ($analytics->current_avg_manpower > 0 && $analytics->current_avg_progress <= 0.05) {
            $insightDAO->updateOrCreate([
                'building_id'            => $report->building_id,
                'construction_report_id' => $report->id,
                'phase'                  => $report->phase,
                'type'                   => InsightType::STAGNATION_GAP,
                'severity'               => InsightSeverity::DANGER,
                'title'                  => [
                    'ar' => 'خطر حرج: توقف العمل وهدر الأجور',
                    'en' => 'Critical Danger: Work Stagnation and Wage Waste'
                ],
                'diagnosis'              => [
                    'ar' => "يتواجد متوسط {$curManpower} عامل بالموقع في آخر 3 أيام، ولكن نسبة الإنجاز اليومي شبه معدومة ({$curProgress}%). هناك هدر مالي مباشر بدون تقدم زمني.",
                    'en' => "An average of {$curManpower} workers are on site over the last 3 days, but daily progress is almost zero ({$curProgress}%). Direct financial waste with no timeline progress."
                ],
                'recommendation'         => [
                    'ar' => "يُرجى إيقاف استنزاف أجور العمالة فوراً وفحص أسباب التوقف (مثل تأخر التوريد أو القرارات الميدانية).",
                    'en' => "Please stop labor wage drainage immediately and investigate stagnation causes (e.g., supply delays or field decisions)."
                ],
                'metrics'                => [
                    'current_avg_manpower' => $curManpower,
                    'current_avg_progress' => $curProgress,
                ]
            ]);
        } elseif (
            $analytics->current_avg_manpower > $analytics->past_avg_manpower &&
            $analytics->current_avg_progress < $analytics->past_avg_progress &&
            $currentWorkerProd <= ($pastWorkerProd * 0.70)
        ) {
            $dropPercentage = $pastWorkerProd > 0 ? round((($pastWorkerProd - $currentWorkerProd) / $pastWorkerProd) * 100, 1) : 0;

            $insightDAO->updateOrCreate([
                'building_id'            => $report->building_id,
                'construction_report_id' => $report->id,
                'phase'                  => $report->phase,
                'type'                   => InsightType::LABOR_OVERCROWDING,
                'severity'               => InsightSeverity::WARNING,
                'title'                  => [
                    'ar' => 'تنبيه اكتظاظ عمالة وتراجع الإنتاجية',
                    'en' => 'Warning: Labor Overcrowding and Productivity Drop'
                ],
                'diagnosis'              => [
                    'ar' => "ارتفع متوسط عدد العمال من {$pastManpower} إلى {$curManpower} عامل، بينما انخفض متوسط الإنجاز اليومي من {$pastProgress}% إلى {$curProgress}%. تراجعت إنتاجية العامل الفردي بنسبة {$dropPercentage}%.",
                    'en' => "Average manpower increased from {$pastManpower} to {$curManpower} workers, while average daily progress dropped from {$pastProgress}% to {$curProgress}%. Individual productivity decreased by {$dropPercentage}%."
                ],
                'recommendation'         => [
                    'ar' => "يُوصى بتقليل حجم العمالة بالمنطقة أو إعادة توزيع العمال على مراحل أخرى لمنع الازداحام وهدر التكلفة.",
                    'en' => "It is recommended to reduce labor volume in the area or redistribute workers to other phases to prevent overcrowding and cost waste."
                ],
                'metrics'                => [
                    'past_avg_manpower'    => $pastManpower,
                    'current_avg_manpower' => $curManpower,
                    'past_avg_progress'    => $pastProgress,
                    'current_avg_progress' => $curProgress,
                    'productivity_drop'    => $dropPercentage,
                ]
            ]);
        } elseif ($currentWorkerProd >= ($pastWorkerProd * 1.30) && $analytics->current_avg_progress > $analytics->past_avg_progress) {
            $increasePercentage = $pastWorkerProd > 0 ? round((($currentWorkerProd - $pastWorkerProd) / $pastWorkerProd) * 100, 1) : 0;

            $insightDAO->updateOrCreate([
                'building_id'            => $report->building_id,
                'construction_report_id' => $report->id,
                'phase'                  => $report->phase,
                'type'                   => InsightType::HIGH_PRODUCTIVITY,
                'severity'               => InsightSeverity::SUCCESS,
                'title'                  => [
                    'ar' => 'ارتفاع ملموس بإنتاجية العمالة',
                    'en' => 'Significant Rise in Labor Productivity'
                ],
                'diagnosis'              => [
                    'ar' => "ارتفعت إنتاجية العمالة الفردية بمقدار {$increasePercentage}% مع تسارع نسبة الإنجاز اليومي إلى {$curProgress}%.",
                    'en' => "Individual labor productivity increased by {$increasePercentage}% with daily progress accelerating to {$curProgress}%."
                ],
                'recommendation'         => [
                    'ar' => "خط سير العمل ممتاز بهذه المرحلة، يُنصح بالاستمرار على نفس توزيع المهام.",
                    'en' => "Workflow is excellent at this phase. It is advised to maintain the current task distribution."
                ],
                'metrics'                => [
                    'productivity_increase' => $increasePercentage,
                    'current_avg_progress'  => $curProgress,
                ]
            ]);
        }
    }
}
