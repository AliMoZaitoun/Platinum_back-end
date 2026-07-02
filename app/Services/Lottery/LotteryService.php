<?php

namespace App\Services\Lottery;

use App\DAO\Lottery\LotteryDAO;
use App\DAO\Lottery\LotteryRuleDAO;
use App\DAO\Lottery\LotteryParticipantDAO;
use App\DTOs\Lottery\Create\CreateLotteryDTO;
use App\DTOs\Lottery\Update\UpdateLotteryDTO;
use App\Exceptions\V1\Lottery\LotteryNotOpenException;
use App\Exceptions\V1\Lottery\NoEligibleParticipantsException;
use App\Services\TransactionService;
use Exception;
use Illuminate\Support\Facades\DB;

class LotteryService
{
    public function __construct(
        private LotteryDAO $lotteryDAO,
        private LotteryRuleDAO $ruleDAO,
        private LotteryParticipantDAO $participantDAO,
        private TransactionService $transaction
    ) {}

    public function index(array $relations = [], int $perPage = 15)
    {
        return $this->lotteryDAO->index($relations, $perPage);
    }

    public function createLottery(CreateLotteryDTO $dto)
    {
        return $this->transaction->execute(function () use ($dto) {
            $lottery = $this->lotteryDAO->store($dto);

            foreach ($dto->rules as $rule) {
                $this->ruleDAO->store($lottery->id, $rule);
            }

            $eligibleClientIds = $this->lotteryDAO->getEligibleClients($dto->unit_id, $dto->rules);

            if ($eligibleClientIds->isNotEmpty()) {
                $this->participantDAO->addParticipants($lottery->id, $eligibleClientIds->toArray());
            }

            return $lottery;
        });
    }

    public function update(int $id, UpdateLotteryDTO $dto)
    {
        return $this->transaction->execute(function () use ($id, $dto) {
            $lottery = $this->lotteryDAO->show($id);

            if ($lottery->status !== 'open') {
                throw new LotteryNotOpenException("messages.lottery.cannot_update");
            }

            $lottery = $this->lotteryDAO->update($id, $dto);
            $this->ruleDAO->destroyByLotId($id);

            foreach ($dto->rules as $rule) {
                $this->ruleDAO->store($id, $rule);
            }

            $this->participantDAO->destroyByLotId($id);

            $eligibleClientIds = $this->lotteryDAO->getEligibleClients($lottery->unit_id, $dto->rules);

            if ($eligibleClientIds->isNotEmpty()) {
                $this->participantDAO->addParticipants($id, $eligibleClientIds->toArray());
            }

            return $lottery;
        });
    }

    public function cancelLottery(int $id)
    {
        return $this->transaction->execute(function () use ($id) {
            $lottery = $this->lotteryDAO->show($id);

            if ($lottery->status !== 'open') {
                throw new LotteryNotOpenException("messages.lottery.cannot_cancel");
            }

            $lottery->update(['status' => 'cancelled']);

            $this->participantDAO->destroyByLotId($id);

            return $lottery;
        });
    }

    public function drawWinner(int $id)
    {
        return $this->transaction->execute(function () use ($id) {
            $lottery = $this->lotteryDAO->show($id);

            if ($lottery->status !== 'open') {
                throw new LotteryNotOpenException("messages.lottery.cannot_draw");
            }

            $participants = $this->participantDAO->readByLotId($id);

            if ($participants->isEmpty()) {
                throw new NoEligibleParticipantsException();
            }

            $luckyParticipant = $participants->random();

            $luckyParticipant->update(['is_winner' => true]);

            $lottery->update([
                'winner_client_id' => $luckyParticipant->client_id,
                'status' => 'completed'
            ]);

            return $lottery;
        });
    }

    public function show(int $id)
    {
        return $this->lotteryDAO->show($id);
    }

    public function destroy(int $id)
    {
        return $this->lotteryDAO->destroy($id);
    }
}
