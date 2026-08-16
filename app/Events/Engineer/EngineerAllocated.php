<?php

namespace App\Events\Engineer;

use App\Models\Engineer\ProjectEngineerAllocation;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EngineerAllocated
{
    use Dispatchable, SerializesModels;

    public function __construct(public ProjectEngineerAllocation $allocation) {}
}
