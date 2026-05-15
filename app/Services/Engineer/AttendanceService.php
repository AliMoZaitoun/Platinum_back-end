<?php

namespace App\Services\Engineer;

use App\DAO\Engineer\AttendanceDAO;
use App\DAO\RealEstate\ProjectDAO;
use App\DTOs\Engineer\Create\CheckInDTO;
use App\DTOs\Engineer\Create\CheckOutDTO;
use App\DTOs\Engineer\Create\MakeAttendanceDTO;
use App\DTOs\Engineer\Update\UpdateAttendanceDTO;
use App\Exceptions\DeviceMismatchException;
use App\Exceptions\OutOfGeofenceException;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;

class AttendanceService
{
    public function __construct(
        private AttendanceDAO $attendanceDAO,
        private ProjectDAO $projectDAO
    ) {}

    public function index()
    {
        return $this->attendanceDAO->index();
    }

    public function storeCheckIn(CheckInDTO $dto)
    {
        $project = $this->projectDAO->show($dto->project_id);

        $this->verifyGeofence($project, $dto->check_in_lat, $dto->check_in_lng);

        $user = Auth::user();
        $dto->engineer_id = $user->engineer->id;

        $lastAttendance = $this->attendanceDAO->getLastAttendanceOfEngineer($dto->engineer_id);

        if ($lastAttendance && $lastAttendance->device_id !== $dto->device_id) {
            throw new DeviceMismatchException();
        }
        return $this->attendanceDAO->storeCheckIn($dto);
    }

    public function storeCheckOut(CheckOutDTO $dto)
    {
        $project = $this->projectDAO->show($dto->project_id);
        $this->verifyGeofence($project, $dto->check_out_lat, $dto->check_out_lng);

        $attendance = $this->attendanceDAO->findByUuid($dto->uuid);
        $dto->engineer_id = $attendance->engineer_id;

        if ($attendance && $attendance->device_id !== $dto->device_id) {
            throw new DeviceMismatchException();
        }

        $updatedAttendance = $this->attendanceDAO->storeCheckOut($dto);

        if ($updatedAttendance->checked_in_at && $updatedAttendance->checked_out_at) {
            $checkInTime = Carbon::parse($updatedAttendance->checked_in_at);
            $checkOutTime = Carbon::parse($updatedAttendance->checked_out_at);

            $totalMinutes = $checkInTime->diffInMinutes($checkOutTime);
            $totalHours = round($totalMinutes / 60, 2);

            $updatedAttendance->update([
                'total_hours' => $totalHours
            ]);
        }
        return $updatedAttendance;
    }

    public function show(int $id)
    {
        return $this->attendanceDAO->show($id);
    }

    public function destroy(int $id)
    {
        return $this->attendanceDAO->destroy($id);
    }


    # Haversine Formula
    private function calculateDistance($lat1, $lon1, $lat2, $lon2): float
    {
        $earthRadius = 6371000;

        $latDelta = deg2rad($lat2 - $lat1);
        $lonDelta = deg2rad($lon2 - $lon1);

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($lonDelta / 2) * sin($lonDelta / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    private function verifyGeofence($project, $lat, $lng): void
    {
        $distance = $this->calculateDistance(
            (float) $lat,
            (float) $lng,
            (float) $project->latitude,
            (float) $project->longitude
        );

        if ($distance > $project->radius_meters) {
            throw new OutOfGeofenceException(round($distance));
        }
    }
}
