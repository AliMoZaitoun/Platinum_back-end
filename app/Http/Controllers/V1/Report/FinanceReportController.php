<?php

namespace App\Http\Controllers\V1\Report;

use App\Http\Controllers\Controller;
use App\Services\Report\FinanceReportService;
use App\Traits\ResponseTrait;

class FinanceReportController extends Controller
{
    use ResponseTrait;
    public function __construct(private FinanceReportService $service) {}

    public function index()
    {
        $data = $this->service->getDashboardNumbers();
        return $this->successResponse($data, 'تم جلب الإحصائيات المالية بنجاح');
    }

    public function downloadPdf()
    {
        return $this->service->exportFinanceSummaryPdf();
    }
}
