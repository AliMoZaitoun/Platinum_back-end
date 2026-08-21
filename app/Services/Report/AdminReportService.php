<?php

namespace App\Services\Report;

use App\DAO\Report\DashboardDAO;

class AdminReportService
{
    public function __construct(
        private DashboardDAO $dashboardDAO,
        private PdfExportService $pdfService
    ) {}

    public function getDashboardNumbers(): array
    {
        return [
            'total_revenue' => $this->dashboardDAO->getTotalRevenue(),
            'contracts'     => $this->dashboardDAO->getContractsStats(),
            'complaints'    => $this->dashboardDAO->getComplaintsStats(),
            'units'         => $this->dashboardDAO->getUnitsStats(),
        ];
    }

    public function exportExecutiveSummaryPdf()
    {
        $data = $this->getDashboardNumbers();

        return $this->pdfService->generate(
            view: 'reports.admin-summary',
            data: $data,
            fileName: 'executive_summary_' . now()->format('Y_m_d') . '.pdf'
        );
    }
}
