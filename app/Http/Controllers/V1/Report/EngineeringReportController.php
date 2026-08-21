<?php

namespace App\Http\Controllers\V1\Report;

use App\Http\Controllers\Controller;
use App\Services\Report\EngineeringReportService;
use App\Traits\ResponseTrait;

class EngineeringReportController extends Controller
{
    use ResponseTrait;
    public function __construct(private EngineeringReportService $service) {}

    public function index()
    {
        $data = $this->service->getDashboardNumbers();
        return $this->successResponse($data, 'تم جلب الإحصائيات الهندسية بنجاح');
    }

    public function downloadPdf()
    {
        return $this->service->exportEngineeringSummaryPdf();
    }
}
