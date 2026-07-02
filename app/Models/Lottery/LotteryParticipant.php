<?php

namespace App\Models\Lottery;

use App\Models\Client\Client;
use App\Models\Lottery\Lottery;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['lottery_id', 'client_id', 'entry_date', 'is_winner'])]
class LotteryParticipant extends Model
{
    public function lottery()
    {
        return $this->belongsTo(Lottery::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
