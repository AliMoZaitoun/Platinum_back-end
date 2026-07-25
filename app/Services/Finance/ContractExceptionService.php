<?php

namespace App\Services\Finance;

use App\DAO\Finance\ContractExceptionDAO;
use App\DAO\Legal\ContractDAO;
use App\DTOs\Finance\Create\ReviewContractExceptionDTO;
use App\Services\Legal\ContractService;
use App\Services\Transaction;

class ContractExceptionService
{
    public function __construct(
        private ContractExceptionDAO $contractExceptionDAO,
        private ContractDAO $contractDAO,
        private ContractService $contractService,
        private Transaction $transaction
    ) {}

    public function index(array $relations = ['contract', 'requester'], int $perPage = 15)
    {
        return $this->contractExceptionDAO->index($relations, $perPage);
    }

    public function show(int $id, array $relations = ['contract.payments', 'requester', 'reviewer'])
    {
        return $this->contractExceptionDAO->show($id, $relations);
    }

    public function review(int $exceptionId, ReviewContractExceptionDTO $dto)
    {
        return $this->transaction->execute(function () use ($exceptionId, $dto) {
            $exception = $this->contractExceptionDAO->show($exceptionId);

            $this->contractExceptionDAO->review($exceptionId, $dto);

            $contractId = $exception->contract_id;

            if ($dto->isApproved()) {
                $contract = $this->contractDAO->updateStatus($contractId, 'active');

                $this->contractService->generatePayments($contract);
            } else {
                $contract = $this->contractDAO->updateStatus($contractId, 'rejected');
            }

            return $this->contractExceptionDAO->show($exceptionId);
        });
    }
}
