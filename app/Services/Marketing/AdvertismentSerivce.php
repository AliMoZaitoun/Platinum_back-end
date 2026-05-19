<?php

namespace App\Services\Marketing;

use App\DAO\Marketing\AdvertismentDAO;
use App\DTOs\Marketing\Create\CreateAdDTO;
use App\DTOs\Marketing\Update\UpdateAdDTO;
use App\Exceptions\NoResultsException;
use App\Services\FileManagerService;
use App\Services\TransactionService;
use App\Services\TranslationService;
use Illuminate\Support\Facades\Auth;

class AdvertismentSerivce
{
    public function __construct(
        private AdvertismentDAO $dao,
        private FileManagerService $fileManager,
        private TransactionService $transaction,
        private TranslationService $translationService
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
            $data = $dto->toArray();
            $data['title'] = $this->translationService->translateAll($dto->title);

            $data['description'] = $this->translationService->translateAll($dto->description);

            $advertisment = $this->dao->store($data);

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
