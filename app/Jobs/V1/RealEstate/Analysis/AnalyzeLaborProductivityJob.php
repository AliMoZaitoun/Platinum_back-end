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

        // 🔴 1. حالة الخطر الشديد (DANGER): توقف وتجمّد العمل بالكامل (STAGNATION_GAP)
        if ($analytics->current_avg_manpower > 0 && $analytics->current_avg_progress <= 0.05) {
            $insightDAO->updateOrCreate([
                'building_id'            => $report->building_id,
                'construction_report_id' => $report->id,
                'phase'                  => $report->phase,
                'type'                   => InsightType::STAGNATION_GAP,
                'severity'               => InsightSeverity::DANGER,
                'title'                  => 'خطر حرج: توقف العمل وهدر الأجور',
                'diagnosis'              => "يتواجد متوسط " . round($analytics->current_avg_manpower, 1) . " عامل بالموقع في آخر 3 أيام، ولكن نسبة الإنجاز اليومي شبه معدومة (" . round($analytics->current_avg_progress, 2) . "%). هناك هدر مالي مباشر بدون تقدم زمني.",
                'recommendation'         => "يُرجى إيقاف استنزاف أجور العمالة فوراً وفحص أسباب التوقف (مثل تأخر التوريد أو القرارات الميدانية).",
                'metrics'                => [
                    'current_avg_manpower' => round($analytics->current_avg_manpower, 1),
                    'current_avg_progress' => round($analytics->current_avg_progress, 2),
                ]
            ]);

            Log::error("🔴 [Stagnation Gap Danger] Created for Report ID: {$report->id}");
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
                'title'                  => 'تنبيه اكتظاظ عمالة وتراجع الإنتاجية',
                'diagnosis'              => "ارتفع متوسط عدد العمال من " . round($analytics->past_avg_manpower, 1) . " إلى " . round($analytics->current_avg_manpower, 1) . " عامل، بينما انخفض متوسط الإنجاز اليومي من " . round($analytics->past_avg_progress, 2) . "% إلى " . round($analytics->current_avg_progress, 2) . "%. تراجعت إنتاجية العامل الفردي بنسبة {$dropPercentage}%.",
                'recommendation'         => "يُوصى بتقليل حجم العمالة بالمنطقة أو إعادة توزيع العمال على مراحل أخرى لمنع الازداحام وهدر التكلفة.",
                'metrics'                => [
                    'past_avg_manpower'    => round($analytics->past_avg_manpower, 1),
                    'current_avg_manpower' => round($analytics->current_avg_manpower, 1),
                    'past_avg_progress'    => round($analytics->past_avg_progress, 2),
                    'current_avg_progress' => round($analytics->current_avg_progress, 2),
                    'productivity_drop'    => $dropPercentage,
                ]
            ]);

            Log::warning("⚠️ [Labor Overcrowding Insight] Created for Report ID: {$report->id}");
        } elseif ($currentWorkerProd >= ($pastWorkerProd * 1.30) && $analytics->current_avg_progress > $analytics->past_avg_progress) {
            $increasePercentage = $pastWorkerProd > 0 ? round((($currentWorkerProd - $pastWorkerProd) / $pastWorkerProd) * 100, 1) : 0;

            $insightDAO->updateOrCreate([
                'building_id'            => $report->building_id,
                'construction_report_id' => $report->id,
                'phase'                  => $report->phase,
                'type'                   => InsightType::HIGH_PRODUCTIVITY,
                'severity'               => InsightSeverity::SUCCESS,
                'title'                  => 'ارتفاع ملموس بإنتاجية العمالة',
                'diagnosis'              => "ارتفعت إنتاجية العمالة الفردية بمقدار {$increasePercentage}% مع تسارع نسبة الإنجاز اليومي إلى " . round($analytics->current_avg_progress, 2) . "%.",
                'recommendation'         => "خط سير العمل ممتاز بهذه المرحلة، يُنصح بالاستمرار على نفس توزيع المهام.",
                'metrics'                => [
                    'productivity_increase' => $increasePercentage,
                    'current_avg_progress'  => round($analytics->current_avg_progress, 2),
                ]
            ]);
        }
    }
}
