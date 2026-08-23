<?php

namespace App\Events\Lottery;

use App\Models\Lottery\Lottery;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class ClientsAddedToLottery
{
    use Dispatchable, SerializesModels;

    public function __construct(public Lottery $lottery, public array $clientIds) {}
}
