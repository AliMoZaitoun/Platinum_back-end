<?php

namespace App\Services\Report;

use App\DAO\Report\InventoryReportDAO;

class InventoryReportService
{
    public function __construct(
        private InventoryReportDAO $dao,
        private PdfExportService $pdfService
    ) {}

    public function getDashboardNumbers(): array
    {
        return [
            'warehouses' => $this->dao->getWarehousesStats(),
            'status'     => $this->dao->getItemsStatusStats(),
            'alerts'     => $this->dao->getAlertsStats(),
        ];
    }

    public function exportInventorySummaryPdf()
    {
        $data = $this->getDashboardNumbers();

        return $this->pdfService->generate(
            view: 'reports.inventory-summary',
            data: $data,
            fileName: 'inventory_summary_' . now()->format('Y_m_d') . '.pdf'
        );
    }
}
