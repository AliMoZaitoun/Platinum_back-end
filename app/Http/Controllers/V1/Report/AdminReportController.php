<?php

namespace App\Http\Controllers\V1\Report;

use App\Http\Controllers\Controller;
use App\Services\Report\AdminReportService;
use App\Traits\ResponseTrait;

class AdminReportController extends Controller
{
    use ResponseTrait;
    public function __construct(private AdminReportService $service) {}

    public function index()
    {
        $data = $this->service->getDashboardNumbers();
        return $this->successResponse($data, 'تم جلب الإحصائيات بنجاح');
    }

    public function downloadPdf()
    {
        return $this->service->exportExecutiveSummaryPdf();
    }
}
