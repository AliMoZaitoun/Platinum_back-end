<?php

namespace App\Http\Controllers\V1\Engineer;

use App\DTOs\Engineer\Create\CheckInDTO;
use App\DTOs\Engineer\Create\CheckOutDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Engineer\CheckInAttRequest;
use App\Http\Requests\V1\Engineer\CheckOutAttRequest;
use App\Http\Resources\V1\Engineer\AttendanceResource;
use App\Services\Engineer\AttendanceService;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    use ResponseTrait;
    public function __construct(
        private AttendanceService $attendanceService
    ) {}

    public function index()
    {
        $atts = $this->attendanceService->index();
        return $this->successCollection($atts, AttendanceResource::class);
    }

    public function storeCheckIn(CheckInAttRequest $request)
    {
        $dto = CheckInDTO::fromRequest($request->validated());

        $attendance = $this->attendanceService->storeCheckIn($dto);
        return $this->useResource($attendance, AttendanceResource::class, __('messages.common.stored'), 201);
    }

    public function storeCheckOut(CheckOutAttRequest $request)
    {
        $dto = CheckOutDTO::fromRequest($request->validated());

        $engineer = request()->user()->engineer;
        $dto->engineer_id = $engineer->id;

        $attendance = $this->attendanceService->storeCheckOut($dto);
        return $this->useResource($attendance, AttendanceResource::class, __('messages.common.updated'));
    }

    public function show(int $id)
    {
        $attendance = $this->attendanceService->show($id);
        return $this->useResource($attendance, AttendanceResource::class);
    }

    public function update() {}

    public function destroy(int $id)
    {
        $this->attendanceService->destroy($id);
        return $this->successResponse([], __('messages.common.deleted'));
    }
}
