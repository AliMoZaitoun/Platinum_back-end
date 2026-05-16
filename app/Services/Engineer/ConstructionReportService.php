<?php

namespace App\Services\Engineer;

use App\DAO\Engineer\ConstructionReportDAO;
use App\DTOs\Engineer\Create\CreateReportDTO;
use App\Services\FileManagerService;
use App\Services\TransactionService;
use Illuminate\Support\Facades\Auth;

class ConstructionReportService
{
    public function __construct(
        private ConstructionReportDAO $dao,
        private FileManagerService $fileManager,
        private TransactionService $transaction
    ) {}

    public function index()
    {
        return $this->dao->index();
    }

    public function store(CreateReportDTO $dto, $attachments = null)
    {
        return $this->transaction->execute(function () use ($dto, $attachments) {
            $report = $this->dao->store($dto);

            if ($attachments) {
                $this->fileManager->storeFile(
                    model: $report,
                    files: $attachments,
                    folderPath: "projects/{$report->project_id}/reports",
                    relationName: 'media'
                );
            }
            return $report;
        });
    }

    public function attachImagesByUuid(string $reportUuid, array $attachments)
    {
        $report = $this->dao->findByUuid($reportUuid);

        return $this->fileManager->storeFile(
            model: $report,
            files: $attachments,
            folderPath: "projects/{$report->project_id}/reports",
            relationName: 'media'
        );
    }

    public function show(int $id)
    {
        return $this->dao->show($id);
    }

    public function myReports(?int $project_id = null)
    {
        $user = Auth::user();
        $engineer = $user->engineer;

        return $this->dao->engReports($engineer->id, $project_id);
    }

    public function findByUuid(string $uuid)
    {
        return $this->dao->findByUuid($uuid);
    }

    public function destroy(int $id)
    {
        return $this->dao->destroy($id);
    }
}
