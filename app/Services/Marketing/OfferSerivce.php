<?php

namespace App\Services\Marketing;

use App\DAO\Marketing\OfferDAO;
use App\DAO\RealEstate\SolutionDAO;
use App\DAO\RealEstate\UnitDAO;
use App\DTOs\Marketing\Create\CreateOfferDTO;
use App\DTOs\Marketing\Update\UpdateOfferDTO;
use App\Exceptions\NotFoundException;
use App\Models\RealEstate\Solution;
use App\Models\RealEstate\Unit;
use App\Services\TransactionService;

class OfferSerivce
{
    public function __construct(
        private OfferDAO $dao,
        private TransactionService $transaction,
        private UnitDAO $unitDAO,
        private SolutionDAO $solutionDAO
    ) {}

    public function index(array $relations = [], int $perPage = 15)
    {
        return $this->dao->index($relations, $perPage);
    }

    public function activeOffers(array $relations = [], int $perPage = 15)
    {
        return $this->dao->activeOffers($relations, $perPage);
    }

    public function store(array $requestData, int $employeeId)
    {
        return $this->transaction->execute(function () use ($requestData, $employeeId) {

            [$modelClass, $targetDAO] = match ($requestData['offerable_type']) {
                'unit', Unit::class         => [Unit::class, $this->unitDAO],
                'solution', Solution::class => [Solution::class, $this->solutionDAO],
                default => throw new \InvalidArgumentException("نوع العنصر غير مدعوم للعروض"),
            };

            $item = $targetDAO->show($requestData['offerable_id']);

            $oldPrice = (float) $item->price;
            $discountPercentage = (float) $requestData['discount_percentage'];
            $newPrice = $oldPrice - ($oldPrice * ($discountPercentage / 100));

            $dto = CreateOfferDTO::fromRequest(
                data: array_merge($requestData, ['offerable_type' => $modelClass]),
                created_by: $employeeId,
                oldPrice: $oldPrice,
                newPrice: $newPrice
            );

            $this->dao->deactivatePreviousOffers($modelClass, $item->id);

            return $this->dao->store($dto);
        });
    }

    public function show(int $id)
    {
        return $this->dao->show($id);
    }

    public function update(int $id, UpdateOfferDTO $dto)
    {
        return $this->dao->update($id, $dto);
    }

    public function destroy(int $id)
    {
        return $this->dao->destroy($id);
    }
}
