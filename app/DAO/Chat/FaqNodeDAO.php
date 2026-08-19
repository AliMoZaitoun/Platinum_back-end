<?php

namespace App\DAO\Chat;

use App\DTOs\Chat\Faq\Create\CreateFaqNodeDTO;
use App\DTOs\Chat\Faq\Update\UpdateFaqNodeDTO;
use App\Models\FaqNode;
use Illuminate\Database\Eloquent\Collection;

class FaqNodeDAO
{
    public function store(CreateFaqNodeDTO $dto): FaqNode
    {
        return FaqNode::create($dto->toArray());
    }

    public function findById(int $id): ?FaqNode
    {
        return FaqNode::find($id);
    }

    public function update(int $id, UpdateFaqNodeDTO $dto): FaqNode
    {
        $node = FaqNode::findOrFail($id);
        $node->update($dto->toArray());

        return $node;
    }

    public function getAdminTree(): Collection
    {
        return FaqNode::whereNull('parent_id')
            ->with('children')
            ->orderBy('sort_order', 'ASC')
            ->get();
    }

    public function destroy(int $id): bool
    {
        $node = FaqNode::findOrFail($id);
        return $node->delete();
    }

    public function getRootNodes(): Collection
    {
        return FaqNode::whereNull('parent_id')
            ->orderBy('sort_order', 'ASC')
            ->get();
    }

    public function getChildren(int $parentId): Collection
    {
        return FaqNode::where('parent_id', $parentId)
            ->orderBy('sort_order', 'ASC')
            ->get();
    }
}
