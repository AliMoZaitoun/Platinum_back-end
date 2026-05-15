<?php

namespace App\Http\Controllers\V1\Engineer;

use App\DTOs\Engineer\Create\MakeAttendanceDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Engineer\StoreAttendanceRequest;
use App\Http\Resources\V1\Engineer\AttendanceResource;
use App\Services\Engineer\AttendanceService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

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

    public function store(StoreAttendanceRequest $request)
    {
        $dto = MakeAttendanceDTO::fromRequest($request->validated());
        $dto->device_id = $request->userAgent();
        $attendance = $this->attendanceService->store($dto);
        return $this->useResource($attendance, AttendanceResource::class, __('messages.common.stored'), 201);
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
