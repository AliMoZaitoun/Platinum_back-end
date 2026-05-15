<?php

namespace App\Services\RealEstate;

use App\DAO\RealEstate\UnitDAO;
use App\DTOs\RealEstate\Create\CreateUnitDTO;
use App\DTOs\RealEstate\Update\UpdateUnitDTO;
use App\Services\TranslationService;
use InvalidArgumentException;

class UnitService
{
    public function __construct(
        private UnitDAO $unitDAO,
        private TranslationService $translationService
    ) {}

    public function index(array $relations = [])
    {
        return $this->unitDAO->index($relations);
    }

    public function byBuilding(int $building_id, array $relations = [])
    {
        return $this->unitDAO->byBuilding($building_id, $relations);
    }

    public function store(CreateUnitDTO $dto)
    {
        $data = $dto->toArray();

        if ($dto->description) {
            $data['description'] = $this->translationService->translateAll($dto->description);
        }

        return $this->unitDAO->store($data);
    }

    public function show(int $id)
    {
        return $this->unitDAO->show($id);
    }

    public function search(array $data)
    {
        if (isset($data['price_min']) && $data['price_min'] < 0) {
            throw new InvalidArgumentException("السعر لا يمكن أن يكون سالباً");
        }
        $filters = collect($data)->only(['location_id', 'price_min', 'price_max', 'type', 'rooms_count'])->toArray();

        return $this->unitDAO->search($filters);
    }

    public function update(int $id, UpdateUnitDTO $unitDTO)
    {
        return $this->unitDAO->update($id, $unitDTO);
    }

    public function destroy($id)
    {
        return $this->unitDAO->destroy($id);
    }
}
