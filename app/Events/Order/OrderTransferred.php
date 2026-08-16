<?php

namespace App\Events\Order;

use App\Models\Sales\Order;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderTransferred
{
    use Dispatchable, SerializesModels;

    public function __construct(public Order $order) {}
}
