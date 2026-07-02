<?php

namespace App\DAO\Lottery;

use App\DTOs\Lottery\Create\CreateLotteryRuleDTO;
use App\DTOs\Lottery\Update\UpdateLotteryRuleDTO;
use App\Models\Lottery\LotteryRule;

class LotteryRuleDAO
{

    public function index(array $relations = [], int $perPage = 15)
    {
        $defaultRelations = [];
        $allRelations = array_merge($defaultRelations, $relations);
        return LotteryRule::query()
            ->with($allRelations)
            ->latest()
            ->paginate($perPage);
    }

    public function create(CreateLotteryRuleDTO $dto)
    {
        return LotteryRule::create($dto->toArray());
    }

    public function show(int $id)
    {
        return LotteryRule::where('id', $id)->with(['client', 'winner', 'rules'])->get();
    }

    public function update(int $id, UpdateLotteryRuleDTO $dto)
    {
        $lottery = $this->show($id);
        $lottery->update($dto->toArray());
        return $lottery->refresh();
    }

    public function destroy(int $id)
    {
        $lottery = $this->show($id);
        return $lottery->delete();
    }
}
