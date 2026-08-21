<?php

namespace App\Http\Controllers\V1\Report;

use App\Http\Controllers\Controller;
use App\Services\Report\InventoryReportService;
use App\Traits\ResponseTrait;

class InventoryReportController extends Controller
{
    use ResponseTrait;
    public function __construct(private InventoryReportService $service) {}

    public function index()
    {
        $data = $this->service->getDashboardNumbers();
        return $this->successResponse($data, 'تم جلب إحصائيات المستودعات بنجاح');
    }

    public function downloadPdf()
    {
        return $this->service->exportInventorySummaryPdf();
    }
}
