<?php

namespace App\Http\Controllers\V1\Lottery;

use App\Http\Controllers\Controller;
use App\Services\Core\LotteryService;
use Illuminate\Http\Request;

class LotteryController extends Controller
{
    public function __construct(
        private LotteryService $lotteryService
    ) {}
}
