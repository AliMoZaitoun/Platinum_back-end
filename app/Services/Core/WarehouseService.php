<?php

namespace App\Services\Core;

use App\DAO\Core\WarehouseDAO;
use App\DTOs\Core\Create\CreateWarehouseDTO;
use App\DTOs\Core\Update\UpdateWarehouseDTO;
use App\Services\FileManagerService;
use App\Services\Transaction;
use App\Services\TranslationService;

class WarehouseService
{
    public function __construct(
        private WarehouseDAO $warehouseDAO,
        private TranslationService $translationService,
        private Transaction $transaction
    ) {}

    public function store(CreateWarehouseDTO $dto)
    {
        return $this->transaction->execute(function () use ($dto) {
            $data = $dto->toArray();
            $data['name'] = $this->translationService->translateAll($dto->name);

            if ($dto->description) {
                $data['description'] = $this->translationService->translateAll($dto->description);
            }

            return $this->warehouseDAO->store($data);
        });
    }

    public function index()
    {
        return $this->warehouseDAO->index();
    }

    public function show(int $id)
    {
        return $this->warehouseDAO->show($id);
    }

    public function update(int $id, UpdateWarehouseDTO $warehouseDTO)
    {
        return $this->warehouseDAO->update($id, $warehouseDTO);
    }

    public function destroy(int $id)
    {
        return $this->warehouseDAO->destroy($id);
    }
}
