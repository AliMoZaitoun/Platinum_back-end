<?php

namespace App\Services\Core;

use App\DAO\Lottery\LotteryDAO;
use App\DTOs\Lottery\Create\CreateLotteryDTO;
use App\DTOs\Lottery\Update\UpdateLotteryDTO;

class LotteryService
{
    public function __construct(
        private LotteryDAO $lotteryDAO
    ) {}

    public function store(CreateLotteryDTO $dto)
    {
        return $this->lotteryDAO->store($dto);
    }

    public function index()
    {
        return $this->lotteryDAO->index();
    }

    public function show(int $id)
    {
        return $this->lotteryDAO->show($id);
    }

    public function update(int $id, UpdateLotteryDTO $dto)
    {
        return $this->lotteryDAO->update($id, $dto);
    }

    public function destroy(int $id)
    {
        return $this->lotteryDAO->destroy($id);
    }
}
