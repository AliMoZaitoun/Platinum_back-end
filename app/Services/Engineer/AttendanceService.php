<?php

namespace App\Services\Engineer;

use App\DAO\Engineer\AttendanceDAO;
use App\DAO\RealEstate\ProjectDAO;
use App\DTOs\Engineer\Create\MakeAttendanceDTO;
use App\DTOs\Engineer\Update\UpdateAttendanceDTO;
use App\Exceptions\DeviceMismatchException;
use App\Exceptions\OutOfGeofenceException;
use Exception;

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

    public function store(MakeAttendanceDTO $dto)
    {
        $project = $this->projectDAO->show($dto->project_id);
        $this->checkIn($project, $dto->check_in_lat, $dto->check_in_lng);
        $lastAttendance = $this->attendanceDAO->getLastAttendanceOfEngineer($dto->engineer_id);

        if ($lastAttendance && $lastAttendance->device_id !== $dto->device_id) {
            throw new DeviceMismatchException();
        }

        return $this->attendanceDAO->store($dto);
    }

    public function show(int $id)
    {
        return $this->attendanceDAO->show($id);
    }

    public function destroy(int $id)
    {
        return $this->attendanceDAO->destroy($id);
    }

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

    private function checkIn($project, $check_in_lat, $check_in_lng)
    {
        $distance = $this->calculateDistance(
            $check_in_lat,
            $check_in_lng,
            $project['latitude'],
            $project['longitude']
        );

        if ($distance > $project->radius_meters) {
            throw new OutOfGeofenceException(round($distance));
        }
        return true;
    }
}
