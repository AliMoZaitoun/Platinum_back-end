<?php

namespace App\Services\Sales;

use App\DAO\Sales\ComplaintTypeDAO;
use App\DTOs\Sales\Create\CreateComplaintTypeDTO;
use App\Services\TransactionService;
use App\Services\TranslationService;

class ComplaintTypeService
{
    public function __construct(
        private ComplaintTypeDAO $dao,
        private TranslationService $translation,
        private TransactionService $transaction
    ) {}

    public function index()
    {
        return $this->dao->index();
    }

    public function store(CreateComplaintTypeDTO $dto)
    {
        return $this->transaction->execute(function () use ($dto) {
            $data = $dto->toArray();
            $data['title'] = $this->translation->translateAll($dto->title);

            $type = $this->dao->store($data);

            return $type;
        });
    }

    public function show(int $id)
    {
        return $this->dao->show($id);
    }

    public function destroy(int $id)
    {
        return $this->dao->destroy($id);
    }
}
