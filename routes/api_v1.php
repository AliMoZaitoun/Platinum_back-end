<?php

use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\V1\RealEstate\LocationController;
use App\Http\Controllers\V1\Core\EmployeeDepartmentController;
use App\Http\Controllers\V1\Core\SolutionController;
use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\Client\ClientController;
use App\Http\Controllers\V1\Client\FavoriteController;
use App\Http\Controllers\V1\Core\DepartmentController;
use App\Http\Controllers\V1\EmployeeController;
use App\Http\Controllers\V1\EngineerController;
use App\Http\Controllers\V1\Core\ItemController;
use App\Http\Controllers\V1\OtpController;
use App\Http\Controllers\V1\RealEstate\BuildingController;
use App\Http\Controllers\V1\RealEstate\ProjectController;
use App\Http\Controllers\V1\RealEstate\UnitController;
use App\Http\Controllers\V1\RoleController;
use App\Http\Controllers\V1\Sales\AppointmentController;
use App\Http\Controllers\V1\Sales\OrderController;
use App\Http\Controllers\V1\Core\WarehouseController;
use App\Http\Controllers\V1\Sales\AvailabilitySlotController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

// Auth
Route::post('verifyEmail', [AuthController::class, 'verifyEmail']);
Route::post('login', [AuthController::class, 'login']);
Route::post('changePassword', [AuthController::class, 'changePassword'])->middleware('auth:sanctum');
Route::post('forgotPassword', [AuthController::class, 'forgotPassword']);
Route::post('resetPassword', [AuthController::class, 'resetPassword']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Test
Route::post('gemini/{id}', [ClientController::class, 'generatePlan']);
Route::get('listModels', [ClientController::class, 'listModels']);

// OTP
Route::post('resendCode/{userId}', [OtpController::class, 'resendCode']);

// Client
Route::prefix('client')->group(function () {
    Route::post('/', [ClientController::class, 'store']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/', [ClientController::class, 'index'])
            ->middleware(['permission:read.client']);

        Route::get('{id}', [ClientController::class, 'show']);
        Route::put('{id}', [ClientController::class, 'update']);
        Route::delete('{id}', [ClientController::class, 'destroy']);
    });
});

// Engineer
Route::prefix('engineer')->group(function () {
    Route::get('/', [EngineerController::class, 'index'])
        ->middleware(['permission:read.engineer']);

    Route::post('/', [EngineerController::class, 'store']);
    Route::get('{id}', [EngineerController::class, 'show']);

    Route::put('{id}', [EngineerController::class, 'update']);
    Route::delete('{id}', [EngineerController::class, 'destroy']);
});

// Employee
Route::prefix('employee')->group(function () {
    Route::get('/', [EmployeeController::class, 'index']);
    Route::post('/', [EmployeeController::class, 'store']);
    Route::get('{id}', [EmployeeController::class, 'show']);
    Route::put('{id}', [EmployeeController::class, 'update']);
    Route::delete('{id}', [EmployeeController::class, 'destroy']);
});

// Warehouse
Route::prefix('warehouse')->middleware('auth:sanctum')->group(function () {
    Route::post('/', [WarehouseController::class, 'store'])
        ->middleware(['permission:create.warehouse']);

    Route::put('{id}', [WarehouseController::class, 'update'])
        ->middleware(['permission:update.warehouse']);

    Route::get('/', [WarehouseController::class, 'index'])
        ->middleware(['permission:read.warehouse']);

    Route::get('{id}', [WarehouseController::class, 'show'])
        ->middleware(['permission:read.warehouse']);

    Route::delete('{id}', [WarehouseController::class, 'destroy'])
        ->middleware(['permission:delete.warehouse']);
});

// Item
Route::prefix('item')->middleware('auth:sanctum')->group(function () {
    Route::post('/', [ItemController::class, 'store'])
        ->middleware(['permission:create.item']);

    Route::put('{id}', [ItemController::class, 'update'])
        ->middleware(['permission:update.item']);

    Route::get('/', [ItemController::class, 'index'])
        ->middleware(['permission:read.item']);

    Route::get('warehouse/{warehouse_id}', [ItemController::class, 'getItemsByWarehouseID'])
        ->middleware(['permission:read.item']);

    Route::get('{id}', [ItemController::class, 'show'])
        ->middleware(['permission:read.item']);

    Route::delete('{id}', [ItemController::class, 'destroy'])
        ->middleware(['permission:delete.item']);
});

// Role
Route::prefix('role')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [RoleController::class, 'index'])
        ->middleware(['permission:read.role']);

    Route::post('/', [RoleController::class, 'store'])
        ->middleware(['permission:create.role']);

    Route::put('{id}', [RoleController::class, 'update'])
        ->middleware(['permission:update.role']);

    Route::get('{id}', [RoleController::class, 'show'])
        ->middleware(['permission:read.role']);

    Route::get('name/{role_name}', [RoleController::class, 'showByName'])
        ->middleware(['permission:read.role']);

    Route::post('selectPermission/{id}', [RoleController::class, 'selectPermission'])
        ->middleware(['permission:update.role']);

    Route::post('removePermission/{id}', [RoleController::class, 'removePermission'])
        ->middleware(['permission:update.role']);

    Route::delete('{id}', [RoleController::class, 'destroy'])
        ->middleware(['permission:delete.role']);
});

// Department
Route::prefix('department')->middleware('auth:sanctum')->group(function () {
    Route::post('/', [DepartmentController::class, 'store'])
        ->middleware(['permission:create.department']);

    Route::put('{id}', [DepartmentController::class, 'update'])
        ->middleware(['permission:read.department']);

    Route::get('/', [DepartmentController::class, 'index'])
        ->middleware(['permission:read.department']);

    Route::get('{id}', [DepartmentController::class, 'show'])
        ->middleware(['permission:read.department']);

    Route::delete('{id}', [DepartmentController::class, 'destroy'])
        ->middleware(['permission:delete.department']);
});

// Department
Route::prefix('employeeDepartment')->middleware('auth:sanctum')->group(function () {
    Route::post('/', [EmployeeDepartmentController::class, 'store'])
        ->middleware(['permission:create.department']);

    Route::put('{id}', [EmployeeDepartmentController::class, 'update'])
        ->middleware(['permission:read.department']);

    Route::get('/', [EmployeeDepartmentController::class, 'index'])
        ->middleware(['permission:read.department']);

    Route::get('depByEmployee/{employeeId}', [EmployeeDepartmentController::class, 'findByEmployee'])
        ->middleware(['permission:read.department']);

    Route::get('empByDepartment/{departmentId}', [EmployeeDepartmentController::class, 'findByDepartment'])
        ->middleware(['permission:read.department']);

    Route::delete('{id}', [EmployeeDepartmentController::class, 'destroy'])
        ->middleware(['permission:delete.department']);
});


// Solution
Route::prefix('solution')->middleware('auth:sanctum')->group(function () {
    Route::post('/', [SolutionController::class, 'store'])
        ->middleware(['permission:create.solution']);

    Route::put('{id}', [SolutionController::class, 'update'])
        ->middleware(['permission:read.solution']);

    Route::get('/', [SolutionController::class, 'index'])
        ->middleware(['permission:read.solution']);

    Route::get('{id}', [SolutionController::class, 'show'])
        ->middleware(['permission:read.solution']);

    Route::delete('{id}', [SolutionController::class, 'destroy'])
        ->middleware(['permission:delete.solution']);
});

// Location
Route::prefix('location')->middleware('auth:sanctum')->group(function () {
    Route::post('/', [LocationController::class, 'store'])
        ->middleware(['permission:create.location']);

    Route::put('{id}', [LocationController::class, 'update'])
        ->middleware(['permission:read.location']);

    Route::get('/', [LocationController::class, 'index'])
        ->middleware(['permission:read.location']);

    Route::get('{id}', [LocationController::class, 'show'])
        ->middleware(['permission:read.location']);

    Route::delete('{id}', [LocationController::class, 'destroy'])
        ->middleware(['permission:delete.location']);
});

Route::prefix('project')->middleware('auth:sanctum')->group(function () {
    Route::post('/', [ProjectController::class, 'store'])
        ->middleware(['permission:create.project']);

    Route::put('{id}', [ProjectController::class, 'update'])
        ->middleware(['permission:update.project']);

    Route::get('/', [ProjectController::class, 'index']);
    // ->middleware(['permission:read.project']);

    Route::get('{id}', [ProjectController::class, 'show'])
        ->middleware(['permission:read.project']);

    Route::delete('{id}', [ProjectController::class, 'destroy'])
        ->middleware(['permission:delete.project']);
});

Route::prefix('building')->middleware('auth:sanctum')->group(function () {
    Route::post('/', [BuildingController::class, 'store'])
        ->middleware(['permission:create.building']);

    Route::put('{id}', [BuildingController::class, 'update'])
        ->middleware(['permission:update.building']);

    Route::get('ofProject/{project_id}', [BuildingController::class, 'index'])
        ->middleware(['permission:read.building']);

    Route::get('{id}', [BuildingController::class, 'show'])
        ->middleware(['permission:read.building']);

    Route::delete('{id}', [BuildingController::class, 'destroy'])
        ->middleware(['permission:destroy.building']);
});

Route::prefix('unit')->middleware('auth:sanctum')->group(function () {
    Route::post('/', [UnitController::class, 'store'])
        ->middleware(['permission:create.unit']);

    Route::put('{id}', [UnitController::class, 'update'])
        ->middleware(['permission:update.unit']);

    Route::get('ofBuilding/{building_id}', [UnitController::class, 'index'])
        ->middleware(['permission:read.unit']);

    Route::get('search', [UnitController::class, 'search']);

    Route::get('{id}', [UnitController::class, 'show'])
        ->middleware(['permission:read.unit']);

    Route::delete('{id}', [UnitController::class, 'destroy'])
        ->middleware(['permission:destroy.unit']);
});

Route::prefix('favorite')->middleware('auth:sanctum')->group(function () {
    Route::get('my', [FavoriteController::class, 'index'])
        ->middleware(['permission:read.favorite']);

    Route::post('{unit_id}', [FavoriteController::class, 'store'])
        ->middleware(['permission:create.favorite']);

    Route::get('{id}', [FavoriteController::class, 'show'])
        ->middleware(['permission:read.favorite']);

    Route::delete('{id}', [FavoriteController::class, 'destroy'])
        ->middleware(['permission:delete.favorite']);
});

Route::prefix('order')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [OrderController::class, 'index'])
        ->middleware(['permission:read.order']);

    Route::get('ordersByClient/{client_id}', [OrderController::class, 'ordersByClient'])
        ->middleware(['permission:read.order']);

    Route::get('myOrders', [OrderController::class, 'myOrders']);

    Route::post('/', [OrderController::class, 'store'])
        ->middleware(['permission:create.order']);

    Route::get('{id}', [OrderController::class, 'show'])
        ->middleware(['permission:read.order']);

    Route::put('{id}', [OrderController::class, 'update'])
        ->middleware(['permission:update.order']);

    Route::delete('{id}', [OrderController::class, 'destroy'])
        ->middleware(['permission:delete.order']);
});

Route::prefix('availableSlot')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [AvailabilitySlotController::class, 'index'])
        ->middleware(['permission:read.availableSlot']);

    Route::post('/', [AvailabilitySlotController::class, 'store'])
        ->middleware(['permission:create.availableSlot']);

    Route::get('{id}', [AvailabilitySlotController::class, 'show'])
        ->middleware(['permission:read.availableSlot']);

    Route::put('{id}', [AvailabilitySlotController::class, 'update'])
        ->middleware(['permission:update.availableSlot']);

    Route::delete('{id}', [AvailabilitySlotController::class, 'destroy'])
        ->middleware(['permission:delete.availableSlot']);
});

Route::prefix('appointment')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [AppointmentController::class, 'index'])
        ->middleware(['permission:read.appointment']);

    Route::post('/', [AppointmentController::class, 'store'])
        ->middleware(['permission:create.appointment']);

    Route::get('{id}', [AppointmentController::class, 'show'])
        ->middleware(['permission:read.appointment']);

    Route::put('{id}', [AppointmentController::class, 'update'])
        ->middleware(['permission:update.appointment']);

    Route::delete('{id}', [AppointmentController::class, 'destroy'])
        ->middleware(['permission:delete.appointment']);

    Route::get('myAppointments', [AppointmentController::class, 'myAppointments']);
    Route::post('askChangeTime/{id}', [AppointmentController::class, 'askChangeTime']);
});

Route::prefix('advertisment')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [AdvertisementController::class, 'index'])
        ->middleware(['permission:read.advertisment']);

    Route::post('/', [AdvertisementController::class, 'store'])
        ->middleware(['permission:create.advertisment']);

    Route::get('{id}', [AdvertisementController::class, 'show'])
        ->middleware(['permission:read.advertisment']);

    Route::put('{id}', [AdvertisementController::class, 'update'])
        ->middleware(['permission:update.advertisment']);

    Route::delete('{id}', [AdvertisementController::class, 'destroy'])
        ->middleware(['permission:delete.advertisment']);
});

Route::get('/run-seeder', function () {
    Artisan::call('migrate:fresh', [
        '--seed' => true,
        '--force' => true,
    ]);
    return 'Database has been refreshed and seeded!';
});
