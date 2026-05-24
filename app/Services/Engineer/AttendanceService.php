<?php

namespace App\Services\Engineer;

use App\DAO\Engineer\AttendanceDAO;
use App\DAO\RealEstate\BuildingDAO;
use App\DAO\RealEstate\ProjectDAO;
use App\DTOs\Engineer\Create\CheckInDTO;
use App\DTOs\Engineer\Create\CheckOutDTO;

use App\Exceptions\V1\Engineer\Attendance\OutsideGeofenceException;
use App\Exceptions\V1\Engineer\Attendance\AlreadyCheckedInException;
use App\Exceptions\V1\Engineer\Attendance\AttendanceBeforeProjectStartException;
use App\Exceptions\V1\Engineer\Attendance\BuildingProjectMismatchException;
use App\Exceptions\V1\Engineer\Attendance\DeviceMismatchException;
use App\Exceptions\V1\Engineer\Attendance\BuildingRequiredException;
use App\Exceptions\V1\Engineer\Attendance\FutureAttendanceTimeException;
use App\Exceptions\V1\Engineer\Attendance\InvalidCheckOutTimeException;
use App\Exceptions\V1\Engineer\Attendance\NotCheckedInYetException;
use App\Exceptions\V1\Engineer\Attendance\LowGpsAccuracyException;
use App\Exceptions\V1\Engineer\Attendance\MockLocationDetectedException;
use App\Exceptions\V1\Engineer\Attendance\OfflineSyncExpiredException;
use App\Exceptions\V1\Engineer\Attendance\ShiftTimeoutException;

use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;

class AttendanceService
{
    private const MAX_GPS_ACCURACY_ALLOWED = 50;

    public function __construct(
        private AttendanceDAO $attendanceDAO,
        private ProjectDAO $projectDAO,
        private BuildingDAO $buildingDAO,
    ) {}

    public function index()
    {
        return $this->attendanceDAO->index();
    }

    public function storeCheckIn(CheckInDTO $dto)
    {
        $user = Auth::user();
        $dto->engineer_id = $user->engineer->id;

        $this->validateGpsSignal($dto->is_mock, $dto->gps_accuracy);

        $lastAttendance = $this->attendanceDAO->getLastAttendanceOfEngineer($dto->engineer_id);

        if ($lastAttendance) {
            if (is_null($lastAttendance->checked_out_at) && !Carbon::parse($lastAttendance->checked_in_at)->isToday()) {
                throw new ShiftTimeoutException(Carbon::parse($lastAttendance->checked_in_at)->format('Y-m-d'));
            }

            if (Carbon::parse($lastAttendance->checked_in_at)->isToday()) {
                throw new AlreadyCheckedInException(Carbon::parse($lastAttendance->checked_in_at)->format('H:i'));
            }

            if ($lastAttendance->device_id !== $dto->device_id) {
                throw new DeviceMismatchException();
            }
        }

        $targetLat = null;
        $targetLng = null;
        $allowedRadius = null;
        $startDate = null;
        if ($dto->building_id) {
            $building = $this->buildingDAO->show($dto->building_id);

            if ((int) $building->project_id !== (int) $dto->project_id) {
                throw new BuildingProjectMismatchException();
            }

            $targetLat     = $building->latitude;
            $targetLng     = $building->longitude;
            $allowedRadius = $building->radius_meters;
            $startDate     = $building?->start_date;
        } else {
            $project = $this->projectDAO->show($dto->project_id);

            if ($project->buildings()->count() > 0) {
                throw new BuildingRequiredException();
            }

            $targetLat     = $project->latitude;
            $targetLng     = $project->lonitude;
            $allowedRadius = $project->radius_meters;
            $startDate     = $project->start_date;
        }

        $attendanceDate = Carbon::parse($dto->checked_in_at);
        $startDate = Carbon::parse($startDate)->startOfDay();

        if ($attendanceDate->lt($startDate)) {
            throw new AttendanceBeforeProjectStartException($startDate->format('Y-m-d'));
        }

        $serverTime = Carbon::now();
        $maxOfflineDays = 2;

        if ($attendanceDate->gt($serverTime->addMinutes(5))) {
            throw new FutureAttendanceTimeException();
        }

        if ($attendanceDate->diffInDays($serverTime) > $maxOfflineDays) {
            throw new OfflineSyncExpiredException($maxOfflineDays);
        }

        $this->verifyGeofence($targetLat, $targetLng, $dto->check_in_lat, $dto->check_in_lng, $allowedRadius);

        return $this->attendanceDAO->storeCheckIn($dto);
    }

    public function storeCheckOut(CheckOutDTO $dto)
    {
        $attendance = $this->attendanceDAO->findActiveAttendance($dto->engineer_id);

        if (!$attendance) {
            throw new NotCheckedInYetException();
        }

        $this->validateGpsSignal($dto->is_mock, $dto->gps_accuracy);

        $dto->id = $attendance->id;

        if ($attendance->device_id !== $dto->device_id) {
            throw new DeviceMismatchException();
        }

        $checkInTime = Carbon::parse($attendance->checked_in_at);
        $checkOutTime = Carbon::parse($dto->checked_out_at);

        if ($checkOutTime->lt($checkInTime)) {
            throw new InvalidCheckOutTimeException();
        }

        if ($attendance->building_id) {
            $building = $this->buildingDAO->show($attendance->building_id);
            $this->verifyGeofence($building->latitude, $building->longitude, $dto->check_out_lat, $dto->check_out_lng, $building->radius_meters);
        } else {
            $project = $this->projectDAO->show($attendance->project_id);
            $this->verifyGeofence($project->latitude, $project->longitude, $dto->check_out_lat, $dto->check_out_lng, $project->radius_meters);
        }


        $totalMinutes = $checkInTime->diffInMinutes($checkOutTime);
        $dto->total_hours = round($totalMinutes / 60, 2);

        $updatedAttendance = $this->attendanceDAO->storeCheckOut($dto);

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

    private function verifyGeofence($latitude, $longitude, $userLat, $userLng, $radius_meters): void
    {
        $distance = $this->calculateDistance(
            (float) $userLat,
            (float) $userLng,
            (float) $latitude,
            (float) $longitude
        );

        if ($distance > $radius_meters) {
            throw new OutsideGeofenceException((int) round($distance));
        }
    }

    private function validateGpsSignal(bool $isMock, float $accuracy): void
    {
        if ($isMock) {
            throw new MockLocationDetectedException();
        }

        if ($accuracy > 50) {
            throw new LowGpsAccuracyException($accuracy, self::MAX_GPS_ACCURACY_ALLOWED);
        }
    }
}
