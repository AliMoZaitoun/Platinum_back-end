<?php

namespace App\DAO\Lottery;

use App\Models\Lottery\LotteryParticipant;

class LotteryParticipantDAO
{
    public function addParticipants(int $lotteryId, array $clientIds): void
    {
        $insertData = array_map(fn($clientId) => [
            'lottery_id' => $lotteryId,
            'client_id' => $clientId,
            'entry_date' => now(),
            'is_winner' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ], $clientIds);

        LotteryParticipant::insert($insertData);
    }

    public function destroyByLotId(int $lottery_id)
    {
        return LotteryParticipant::where('lottery_id', $lottery_id)->delete();
    }

    public function readByLotId(int $lottery_id)
    {
        return LotteryParticipant::where('lottery_id', $lottery_id)->get();
    }
}
