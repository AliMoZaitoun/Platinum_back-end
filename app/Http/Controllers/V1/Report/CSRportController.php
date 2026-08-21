<?php

namespace App\Http\Controllers\V1\Report;

use App\Http\Controllers\Controller;
use App\Services\Report\CSRportService;
use App\Traits\ResponseTrait;

class CSRportController extends Controller
{
    use ResponseTrait;
    public function __construct(private CSRportService $service) {}

    public function index()
    {
        $data = $this->service->getDashboardNumbers();
        return $this->successResponse($data, 'تم جلب إحصائيات خدمة العملاء بنجاح');
    }

    public function downloadPdf()
    {
        return $this->service->exportCSummaryPdf();
    }
}
