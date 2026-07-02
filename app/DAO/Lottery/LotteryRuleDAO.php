<?php

namespace App\DAO\Lottery;

use App\Models\Lottery\LotteryRule;

class LotteryRuleDAO
{
    public function store(int $lotteryId, array $ruleData)
    {
        $ruleData['lottery_id'] = $lotteryId;
        return LotteryRule::create($ruleData);
    }

    public function destroyByLotId(int $lottery_id)
    {
        return LotteryRule::where('lottery_id', $lottery_id)->delete();
    }
}
