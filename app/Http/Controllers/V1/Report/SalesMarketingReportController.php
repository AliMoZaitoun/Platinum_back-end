<?php

namespace App\Http\Controllers\V1\Report;

use App\Http\Controllers\Controller;
use App\Services\Report\SalesMarketingReportService;
use App\Traits\ResponseTrait;

class SalesMarketingReportController extends Controller
{
    use ResponseTrait;
    public function __construct(private SalesMarketingReportService $service) {}

    public function index()
    {
        $data = $this->service->getDashboardNumbers();
        return $this->successResponse($data, 'تم جلب إحصائيات المبيعات بنجاح');
    }

    public function downloadPdf()
    {
        return $this->service->exportSalesMarketingSummaryPdf();
    }
}
