<?php

namespace App\Services\RealEstate;

use App\DAO\RealEstate\ProjectDAO;
use App\DTOs\RealEstate\Create\CreateProjectDTO;
use App\DTOs\RealEstate\Update\UpdateProjectDTO;
use App\Services\FileManagerService;
use App\Services\Transaction;
use App\Services\TranslationService;

class ProjectService
{
    public function __construct(
        private ProjectDAO $projectDAO,
        private TranslationService $translationService,
        private Transaction $transaction,
        private FileManagerService $fileManager
    ) {}

    public function index(array $relations = [])
    {
        return $this->projectDAO->index($relations);
    }

    public function store(CreateProjectDTO $dto, $attachments = null)
    {
        return $this->transaction->execute(function () use ($dto, $attachments) {
            $data = $dto->toArray();
            $data['name'] = $this->translationService->translateAll($dto->name);

            if ($dto->description) {
                $data['description'] = $this->translationService->translateAll($dto->description);
            }

            $project = $this->projectDAO->store($data);

            if ($attachments) {
                $this->fileManager->storeFile(
                    model: $project,
                    files: $attachments,
                    folderPath: "projects",
                    relationName: 'attachments'
                );
            }
            return $project;
        });
    }

    public function show(int $id)
    {
        return $this->projectDAO->show($id);
    }

    public function update(int $id, UpdateProjectDTO $projectDTO)
    {
        return $this->projectDAO->update($id, $projectDTO);
    }

    public function destroy(int $id)
    {
        return $this->projectDAO->destroy($id);
    }
}
