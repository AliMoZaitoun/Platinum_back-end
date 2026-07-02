<?php

namespace App\Models\Lottery;

use App\Models\Client\Client;
use App\Models\RealEstate\Unit;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['unit_id', 'title', 'status', 'winner_client_id'])]
class Lottery extends Model
{
    use SoftDeletes;
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function winner()
    {
        return $this->belongsTo(Client::class, 'winner_client_id');
    }

    public function rules()
    {
        return $this->hasMany(LotteryRule::class);
    }

    public function participants()
    {
        return $this->hasMany(LotteryParticipant::class);
    }
}
