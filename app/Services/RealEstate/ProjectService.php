<?php

namespace App\Services\RealEstate;

use App\DAO\RealEstate\ProjectDAO;
use App\DTOs\RealEstate\Create\CreateProjectDTO;
use App\DTOs\RealEstate\Update\UpdateProjectDTO;
use App\Services\TranslationService;

class ProjectService
{
    public function __construct(
        private ProjectDAO $projectDAO,
        private TranslationService $translationService
    ) {}

    public function index(array $relations = [])
    {
        return $this->projectDAO->index($relations);
    }

    public function store(CreateProjectDTO $dto)
    {
        $data = $dto->toArray();
        $data['name'] = $this->translationService->translateAll($dto->name);

        if ($dto->description) {
            $data['description'] = $this->translationService->translateAll($dto->description);
        }
        return $this->projectDAO->store($data);
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
