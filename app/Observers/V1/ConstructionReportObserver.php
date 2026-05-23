<?php

namespace App\Observers\V1;

use App\Jobs\V1\RealEstate\Analysis\AnalyzeLaborProductivityJob;
use App\Jobs\V1\RealEstate\Analysis\AnalyzePhaseBlockedJob;
use App\Models\Engineer\ConstructionReport;

class ConstructionReportObserver
{
    public function created(ConstructionReport $report): void
    {
        AnalyzeLaborProductivityJob::dispatch($report);
        AnalyzePhaseBlockedJob::dispatch($report);
    }
}
