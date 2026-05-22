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

        if (!empty($dto->is_mock) || $dto->is_mock === true) {
            throw new MockLocationDetectedException();
        }

        if (isset($dto->gps_accuracy) && $dto->gps_accuracy > self::MAX_GPS_ACCURACY_ALLOWED) {
            throw new LowGpsAccuracyException((int)$dto->gps_accuracy, self::MAX_GPS_ACCURACY_ALLOWED);
        }

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
        $attendance = $this->attendanceDAO->findByUuid($dto->uuid);

        if (!$attendance) {
            throw new NotCheckedInYetException();
        }

        $dto->engineer_id = $attendance->engineer_id;

        if ($attendance->device_id !== $dto->device_id) {
            throw new DeviceMismatchException();
        }

        if ($attendance->building_id) {
            $building = $this->buildingDAO->show($attendance->building_id);
            $this->verifyGeofence($building->lat, $building->lng, $dto->check_out_lat, $dto->check_out_lng, $building->radius_meters);
        } else {
            $project = $this->projectDAO->show($dto->project_id);
            $this->verifyGeofence($project->lat, $project->lng, $dto->check_out_lat, $dto->check_out_lng, $project->radius_meters);
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
}
