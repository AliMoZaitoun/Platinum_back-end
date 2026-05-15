<?php

namespace App\DAO\Engineer;

use App\DTOs\Engineer\Create\MakeAttendanceDTO;
use App\Exceptions\NotFoundException;
use App\Models\Engineer\Attendance;

class AttendanceDAO
{
    public function index()
    {
        return Attendance::with(['project', 'engineer'])->get();
    }

    public function store(MakeAttendanceDTO $dto)
    {
        return Attendance::updateOrCreate(
            ['uuid' => $dto->uuid],
            $dto->toArray()
        );
    }

    public function show(int $id)
    {
        return Attendance::where('id', $id)->with(['project', 'engineer'])->get() ?? throw new NotFoundException("Attendance");
    }

    public function getLastAttendanceOfEngineer(int $engineerId)
    {
        return Attendance::where('engineer_id', $engineerId)->get()->last();
    }

    public function findByUuid(string $uuid)
    {
        return Attendance::where('uuid', $uuid)->with(['project', 'engineer'])->get()
            ?? throw new NotFoundException("Attendance");
    }

    public function destroy(int $id)
    {
        $attendance = $this->show($id);
        return $attendance->delete();
    }
}
