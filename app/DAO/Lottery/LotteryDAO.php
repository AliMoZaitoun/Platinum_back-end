<?php

namespace App\DAO\Lottery;

use App\DTOs\Lottery\Create\CreateLotteryDTO;
use App\DTOs\Lottery\Update\UpdateLotteryDTO;
use App\Models\Lottery\Lottery;

class LotteryDAO
{

    public function index(array $relations = [], int $perPage = 15)
    {
        $defaultRelations = ['unit', 'rules'];
        $allRelations = array_merge($defaultRelations, $relations);
        return Lottery::query()
            ->with($allRelations)
            ->latest()
            ->paginate($perPage);
    }

    public function store(CreateLotteryDTO $dto)
    {
        return Lottery::create($dto->toArray());
    }

    public function show(int $id)
    {
        return Lottery::where('id', $id)->with(['client', 'winner', 'rules'])->get();
    }

    public function update(int $id, UpdateLotteryDTO $dto)
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
