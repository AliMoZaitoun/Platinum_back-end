<?php

namespace App\Services\RealEstate;

use App\DAO\RealEstate\SolutionDAO;
use App\DTOs\RealEstate\Create\CreateSolutionDTO;
use App\DTOs\RealEstate\Update\UpdateSolutionDTO;
use App\Services\TranslationService;

class SolutionService
{
    public function __construct(
        private SolutionDAO $solutionDAO,
        private TranslationService $translationService
    ) {}

    public function store(CreateSolutionDTO $dto)
    {
        $data = $dto->toArray();
        $data['name'] = $this->translationService->translateAll($dto->name);

        if ($dto->description) {
            $data['description'] = $this->translationService->translateAll($dto->description);
        }

        return $this->solutionDAO->store($data);
    }

    public function index()
    {
        return $this->solutionDAO->index();
    }

    public function show(int $id)
    {
        return $this->solutionDAO->show($id);
    }

    public function update(int $id, UpdateSolutionDTO $SolutionDTO)
    {
        return $this->solutionDAO->update($id, $SolutionDTO);
    }

    public function destroy(int $id)
    {
        return $this->solutionDAO->destroy($id);
    }
}
