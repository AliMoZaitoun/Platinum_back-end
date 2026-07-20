<?php

namespace App\Services\Sales;

use App\DAO\Sales\PaymentDAO;
use App\DTOs\Sales\Create\CreatePaymentDTO;
use App\DTOs\Sales\Update\UpdatePaymentDTO;
use App\Exceptions\V1\Sales\PaymentImmutableException;
use App\Services\FileManagerService;
use App\Services\Transaction;

class PaymentService
{
    public function __construct(
        private PaymentDAO $dao,
        private Transaction $transaction,
        private FileManagerService $fileManager
    ) {}

    public function index(array $relations = [], int $perPage = 15)
    {
        return $this->dao->index($relations, $perPage);
    }

    public function store(CreatePaymentDTO $dto, $attachments = null)
    {
        return $this->transaction->execute(function () use ($dto, $attachments) {
            $payment = $this->dao->store($dto);

            if ($attachments) {
                $this->fileManager->storeFile(
                    model: $payment,
                    files: $attachments,
                    folderPath: "payments",
                    relationName: 'attachments'
                );
            }
            return $payment;
        });
    }

    public function show(int $id)
    {
        return $this->dao->show($id);
    }

    public function byClient(int $client_id)
    {
        return $this->dao->byClient($client_id);
    }

    public function update(int $id, UpdatePaymentDTO $dto, $attachments = null)
    {
        return $this->transaction->execute(function () use ($id, $dto, $attachments) {
            $pay = $this->dao->show($id);

            if ($pay->status !== 'pending') {
                throw new PaymentImmutableException();
            }

            $payment = $this->dao->update($id, $dto);

            if ($attachments) {
                $this->fileManager->storeFile(
                    model: $payment,
                    files: $attachments,
                    folderPath: "payments",
                    relationName: 'attachments'
                );
            }
            return $payment;
        });
    }

    public function uploadFile(int $id, $attachments = null)
    {
        return $this->transaction->execute(function () use ($id, $attachments) {
            $payment = $this->dao->show($id);

            if ($attachments) {
                $this->fileManager->storeFile(
                    model: $payment,
                    files: $attachments,
                    folderPath: "payments",
                    relationName: 'attachments'
                );
            }
            return $payment->refresh();
        });
    }

    public function destroy(int $id)
    {
        return $this->dao->destroy($id);
    }
}
