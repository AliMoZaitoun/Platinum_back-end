<?php

namespace App\DAO\Engineer;

use App\DTOs\Engineer\Create\CheckInDTO;
use App\DTOs\Engineer\Create\CheckOutDTO;
use App\DTOs\Engineer\Create\MakeAttendanceDTO;
use App\Exceptions\NotFoundException;
use App\Models\Engineer\Attendance;
use Carbon\Carbon;

class AttendanceDAO
{
    public function index()
    {
        return Attendance::with(['project', 'engineer'])->get();
    }

    public function storeCheckIn(CheckInDTO $dto)
    {
        return Attendance::updateOrCreate(
            ['uuid' => $dto->uuid],
            $dto->toArray()
        );
    }

    public function storeCheckOut(CheckOutDTO $dto)
    {
        Attendance::where('id', $dto->id)->update($dto->toArray());

        return $this->show($dto->id);
    }

    public function hasAttendance(int $engineer_id, int $building_id, $report_date)
    {
        return Attendance::where('engineer_id', $engineer_id)
            ->where('building_id', $building_id)
            ->whereDate('checked_in_at', Carbon::parse($report_date)->toDateString())
            ->whereNull('checked_out_at')
            ->exists();
    }

    public function show(int $id)
    {
        return Attendance::where('id', $id)->with(['project', 'engineer'])->first() ?? throw new NotFoundException("Attendance");
    }

    public function findActiveAttendance(int $engineerId)
    {
        return Attendance::where('engineer_id', $engineerId)
            ->whereNull('checked_out_at')
            ->latest()
            ->first();
    }

    public function getLastAttendanceOfEngineer(int $engineerId)
    {
        return Attendance::where('engineer_id', $engineerId)->get()->last();
    }

    public function findByUuid(string $uuid)
    {
        return Attendance::where('uuid', $uuid)->first()
            ?? throw new NotFoundException("Attendance");
    }

    public function destroy(int $id)
    {
        $attendance = $this->show($id);
        return $attendance->delete();
    }
}
