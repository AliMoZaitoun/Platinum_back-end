<?php

namespace App\Events\Contract;

use App\Models\Legal\Contract;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ContractCreated
{
    use Dispatchable, SerializesModels;

    public function __construct(public Contract $contract) {}
}
