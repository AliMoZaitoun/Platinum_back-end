<?php

namespace App\Services\Report;

use App\DAO\Report\FinanceReportDAO;

class FinanceReportService
{
    public function __construct(
        private FinanceReportDAO $dao,
        private PdfExportService $pdfService
    ) {}

    public function getDashboardNumbers(): array
    {
        return [
            'overdue'         => $this->dao->getOverdueStats(),
            'cash_flow'       => $this->dao->getMonthlyCashFlow(),
            'payment_methods' => $this->dao->getPaymentMethodsStats(),
        ];
    }

    public function exportFinanceSummaryPdf()
    {
        $data = $this->getDashboardNumbers();

        return $this->pdfService->generate(
            view: 'reports.finance-summary',
            data: $data,
            fileName: 'finance_summary_' . now()->format('Y_m_d') . '.pdf'
        );
    }
}
