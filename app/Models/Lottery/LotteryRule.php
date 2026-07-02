<?php

namespace App\Models\Lottery;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['lottery_id', 'rule_key', 'operator', 'rule_value'])]
class LotteryRule extends Model
{
    public function lottery()
    {
        return $this->belongsTo(Lottery::class);
    }
}
