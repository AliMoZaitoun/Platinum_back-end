<?php

namespace App\Services\Marketing;

use App\DAO\Marketing\AdvertismentDAO;
use App\DTOs\Marketing\Create\CreateAdDTO;
use App\DTOs\Marketing\Update\UpdateAdDTO;
use App\Exceptions\NoResultsException;
use App\Services\FileManagerService;
use App\Services\TransactionService;
use Illuminate\Support\Facades\Auth;

class AdvertismentSerivce
{
    public function __construct(
        private AdvertismentDAO $dao,
        private FileManagerService $fileManager,
        private TransactionService $transaction
    ) {}

    public function index()
    {
        return $this->dao->index();
    }

    public function getActiveAdvertisements()
    {
        return $this->dao->getActiveAdvertisements();
    }

    public function store(CreateAdDTO $dto, $attachments = null)
    {
        return $this->transaction->execute(function () use ($dto, $attachments) {
            $user = Auth::user();
            $dto->created_by = $user->engineer->id ?? 1;
            $advertisment = $this->dao->store($dto);

            if ($attachments) {
                $this->fileManager->storeFile(
                    model: $advertisment,
                    files: $attachments,
                    folderPath: "advertisments",
                    relationName: 'attachments'
                );
            }
            return $advertisment;
        });
    }

    public function show(int $id)
    {
        return $this->dao->show($id);
    }

    public function update(int $id, UpdateAdDTO $dto)
    {
        return $this->dao->update($id, $dto);
    }

    public function destroy(int $id)
    {
        return $this->dao->destroy($id);
    }
}
