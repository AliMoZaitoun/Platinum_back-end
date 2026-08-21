<?php

namespace App\Services\Report;

use App\DAO\Report\CSRportDAO;

class CSRportService
{
    public function __construct(
        private CSRportDAO $dao,
        private PdfExportService $pdfService
    ) {}

    public function getDashboardNumbers(): array
    {
        return [
            'chats'     => $this->dao->getChatStats(),
            'analytics' => $this->dao->getComplaintAnalytics(),
        ];
    }

    public function exportCSummaryPdf()
    {
        $data = $this->getDashboardNumbers();

        return $this->pdfService->generate(
            view: 'reports.cs-summary',
            data: $data,
            fileName: 'cs_summary_' . now()->format('Y_m_d') . '.pdf'
        );
    }
}
