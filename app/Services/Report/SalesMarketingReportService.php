<?php

namespace App\Services\Report;

use App\DAO\Report\SalesMarketingReportDAO;

class SalesMarketingReportService
{
    public function __construct(
        private SalesMarketingReportDAO $dao,
        private PdfExportService $pdfService
    ) {}

    public function getDashboardNumbers(): array
    {
        return [
            'funnel' => $this->dao->getSalesFunnelStats(),
            'ads'    => $this->dao->getAdvertisementsStats(),
            'offers' => $this->dao->getOffersStats(),
        ];
    }

    public function exportSalesMarketingSummaryPdf()
    {
        $data = $this->getDashboardNumbers();

        return $this->pdfService->generate(
            view: 'reports.sales-marketing-summary',
            data: $data,
            fileName: 'sales_marketing_summary_' . now()->format('Y_m_d') . '.pdf'
        );
    }
}
