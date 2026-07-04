<?php

namespace App\Services\Marketing;

use App\DAO\Marketing\OfferDAO;
use App\DTOs\Marketing\Create\CreateOfferDTO;
use App\DTOs\Marketing\Update\UpdateOfferDTO;
use App\Services\TransactionService;
use App\Services\TranslationService;

class OfferSerivce
{
    public function __construct(
        private OfferDAO $dao,
        private TransactionService $transaction,
        private TranslationService $translationService
    ) {}

    public function index()
    {
        return $this->dao->index();
    }

    public function getActiveOffers()
    {
        return $this->dao->getActiveOffers();
    }

    public function store(CreateOfferDTO $dto)
    {
        return $this->transaction->execute(function () use ($dto) {
            $offer = $this->dao->store($dto);

            return $offer;
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
