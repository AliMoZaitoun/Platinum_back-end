<?php

namespace App\Services\Sales;

use App\DAO\Sales\ComplaintDAO;
use App\DAO\Sales\ComplaintTypeDAO;
use App\DTOs\Sales\Create\CreateComplaintDTO;
use App\DTOs\Sales\Create\CreateComplaintTypeDTO;
use App\DTOs\Sales\Update\UpdateComplaintDTO;
use App\Services\FileManagerService;
use App\Services\Transaction;

class ComplaintService
{
    public function __construct(
        private ComplaintDAO $dao,
        private Transaction $transaction,
        private FileManagerService $fileManager,
        private ComplaintTypeService $complaint_type_service
    ) {}

    public function index()
    {
        return $this->dao->index();
    }

    public function clientComplaints(int $client_id)
    {
        return $this->dao->clientComplaints($client_id);
    }

    public function store(CreateComplaintDTO $dto, $attachments = null)
    {
        return $this->transaction->execute(function () use ($dto, $attachments) {

            if ($dto->new_type && !$dto->complaint_type_id) {
                $typeDTO = CreateComplaintTypeDTO::fromRequest($dto->user_id, $dto->toArray());
                $complaintType = $this->complaint_type_service->store($typeDTO);
                $dto->complaint_type_id = $complaintType->id;
            }

            $complaint = $this->dao->store($dto);

            if ($attachments) {
                $this->fileManager->storeFile(
                    model: $complaint,
                    files: $attachments,
                    folderPath: "Complaints",
                    relationName: 'attachments'
                );
            }
            return $complaint;
        });
    }

    public function show(int $id)
    {
        return $this->dao->show($id);
    }

    public function update(int $id, UpdateComplaintDTO $dto)
    {
        return $this->dao->update($id, $dto);
    }

    public function updateStatus(int $id, UpdateComplaintDTO $dto)
    {
        return $this->dao->update($id, $dto);
    }

    public function destroy(int $id)
    {
        return $this->dao->destroy($id);
    }
}
