<?php

namespace App\Services\Report;

use App\DAO\Report\EngineeringReportDAO;

class EngineeringReportService
{
    public function __construct(
        private EngineeringReportDAO $dao,
        private PdfExportService $pdfService
    ) {}

    public function getDashboardNumbers(): array
    {
        return [
            'health'     => $this->dao->getProjectsHealthStats(),
            'engineers'  => $this->dao->getEngineersAllocationStats(),
            'attendance' => $this->dao->getSiteAttendanceStats(),
        ];
    }

    public function exportEngineeringSummaryPdf()
    {
        $data = $this->getDashboardNumbers();

        return $this->pdfService->generate(
            view: 'reports.engineering-summary',
            data: $data,
            fileName: 'engineering_summary_' . now()->format('Y_m_d') . '.pdf'
        );
    }
}
