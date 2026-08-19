<?php

namespace App\Services\Chat;

use App\DAO\Chat\FaqNodeDAO;
use App\DTOs\Chat\Faq\Create\CreateFaqNodeDTO;
use App\DTOs\Chat\Faq\Update\UpdateFaqNodeDTO;
use App\Exceptions\V1\Chat\FaqNodeNotFoundException;
use App\Services\Transaction;
use App\Services\TranslationService;
use Illuminate\Database\Eloquent\Collection;

class FaqNodeService
{
    public function __construct(
        protected FaqNodeDAO $dao,
        protected TranslationService $translationService,
        protected Transaction $transaction
    ) {}

    public function store(array $validatedData)
    {
        return $this->transaction->execute(function () use ($validatedData) {
            $validatedData['title'] = $this->translationService->translateAll($validatedData['title']);

            if (!empty($validatedData['content'])) {
                $validatedData['content'] = $this->translationService->translateAll($validatedData['content']);
            }

            $dto = CreateFaqNodeDTO::fromRequest($validatedData);
            return $this->dao->store($dto);
        });
    }

    public function getAdminTree(): Collection
    {
        return $this->dao->getAdminTree();
    }

    public function show(int $id)
    {
        $node = $this->dao->findById($id);

        if (!$node) {
            throw new FaqNodeNotFoundException();
        }

        return $node;
    }

    public function update(int $id, array $validatedData)
    {
        return $this->transaction->execute(function () use ($id, $validatedData) {
            $this->show($id);

            if (isset($validatedData['title'])) {
                $validatedData['title'] = $this->translationService->translateAll($validatedData['title']);
            }

            if (isset($validatedData['content'])) {
                $validatedData['content'] = $this->translationService->translateAll($validatedData['content']);
            }

            $dto = UpdateFaqNodeDTO::fromRequest($validatedData);
            return $this->dao->update($id, $dto);
        });
    }

    public function destroy(int $id): bool
    {
        $this->show($id);

        return $this->dao->destroy($id);
    }

    public function getRootNodes(): Collection
    {
        return $this->dao->getRootNodes();
    }

    public function getChildren(int $parentId): Collection
    {
        $this->show($parentId);

        return $this->dao->getChildren($parentId);
    }
}
