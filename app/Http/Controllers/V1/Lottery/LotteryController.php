<?php

namespace App\Http\Controllers\V1\Lottery;

use App\Http\Controllers\Controller;
use App\DTOs\Lottery\Create\CreateLotteryDTO;
use App\DTOs\Lottery\Update\UpdateLotteryDTO;
use App\Http\Requests\V1\Lottery\StoreLotteryRequest;
use App\Http\Requests\V1\Lottery\UpdateLotteryRequest;
use App\Http\Resources\V1\Lottery\LotteryResource;
use App\Services\Lottery\LotteryService;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Auth;

class LotteryController extends Controller
{
    use ResponseTrait;

    public function __construct(
        private LotteryService $lotteryService
    ) {}

    public function index()
    {
        $lotteries = $this->lotteryService->index();
        return $this->successCollection($lotteries, LotteryResource::class);
    }

    public function store(StoreLotteryRequest $request)
    {
        $dto = CreateLotteryDTO::fromRequest($request->validated());

        $lottery = $this->lotteryService->createLottery($dto);

        return $this->useResource($lottery, LotteryResource::class);
    }

    public function show(int $id)
    {
        $lottery = $this->lotteryService->show($id);

        return $this->useResource($lottery, LotteryResource::class);
    }

    public function update(int $id, UpdateLotteryRequest $request)
    {
        $dto = UpdateLotteryDTO::fromRequest($request->validated());
        $lottery = $this->lotteryService->update($id, $dto);

        return $this->useResource($lottery, LotteryResource::class);
    }

    public function cancel(int $id)
    {
        $lottery = $this->lotteryService->cancelLottery($id);

        return $this->useResource($lottery, LotteryResource::class);
    }

    public function drawWinner(int $id)
    {
        $lottery = $this->lotteryService->drawWinner($id);
        return $this->useResource($lottery, LotteryResource::class);
    }

    public function destroy(int $id)
    {
        $this->lotteryService->destroy($id);

        return $this->successResponse([], LotteryResource::class);
    }

    public function byClient(int $client_id)
    {
        $lotteries = $this->lotteryService->byClient($client_id);
        return $this->successCollection($lotteries, LotteryResource::class);
    }

    public function forClient()
    {
        $client = Auth::user()->client;
        $lotteries = $this->lotteryService->byClient($client->id);
        return $this->successCollection($lotteries, LotteryResource::class);
    }
}
