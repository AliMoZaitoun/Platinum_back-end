<?php

use App\Http\Controllers\V1\AdminOfferController;
use App\Http\Controllers\V1\NoteController;
use App\Http\Controllers\V1\Lottery\LotteryController;
use App\Http\Controllers\V1\Lottery\LotteryRuleController;
use App\Http\Controllers\V1\Auth\LoginController;
use App\Http\Controllers\V1\Auth\PasswordManagementController;
use App\Http\Controllers\V1\Auth\VerificationController;
use App\Http\Controllers\V1\ChatController;
use App\Http\Controllers\V1\Client\ClientController;
use App\Http\Controllers\V1\Client\FavoriteController;
use App\Http\Controllers\V1\Client\UnitController as ClientUnitController;
use App\Http\Controllers\V1\ClientOfferController;
use App\Http\Controllers\V1\Core\DepartmentController;
use App\Http\Controllers\V1\Core\EmployeeController;
use App\Http\Controllers\V1\Core\EmployeeDepartmentController;
use App\Http\Controllers\V1\Core\ItemController;
use App\Http\Controllers\V1\Core\WarehouseController;
use App\Http\Controllers\V1\Engineer\AttendanceController;
use App\Http\Controllers\V1\Engineer\ConstructionReportController;
use App\Http\Controllers\V1\Engineer\ProjectEngineerAllocationController;
use App\Http\Controllers\V1\Engineer\EngineerController;
use App\Http\Controllers\V1\Marketing\AdvertisementController;
use App\Http\Controllers\V1\OtpController;
use App\Http\Controllers\V1\PermissionController;
use App\Http\Controllers\V1\RealEstate\BuildingController;
use App\Http\Controllers\V1\RealEstate\LocationController;
use App\Http\Controllers\V1\RealEstate\ProjectController;
use App\Http\Controllers\V1\RealEstate\SolutionController;
use App\Http\Controllers\V1\RealEstate\UnitController as AdminUnitController;
use App\Http\Controllers\V1\RoleController;
use App\Http\Controllers\V1\Sales\AppointmentController;
use App\Http\Controllers\V1\Sales\AvailabilitySlotController;
use App\Http\Controllers\V1\Sales\ComplaintController;
use App\Http\Controllers\V1\Sales\ComplaintTypeController;
use App\Http\Controllers\V1\Sales\OrderController;
use App\Http\Controllers\V1\Sales\UnitOwnershipController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;

// Auth
Route::post('verifyEmail', [VerificationController::class, 'verifyEmail']);
Route::post('login', [LoginController::class, 'login']);
Route::post('changePassword', [PasswordManagementController::class, 'changePassword'])->middleware('auth:sanctum');
Route::post('refreshToken', [LoginController::class, 'refreshToken'])->middleware('auth:sanctum');
Route::post('forgotPassword', [PasswordManagementController::class, 'forgotPassword']);
Route::post('resetPassword', [PasswordManagementController::class, 'resetPassword']);
Route::post('logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');

// Test
Route::post('gemini/{id}', [ClientController::class, 'generatePlan']);
Route::get('listModels', [ClientController::class, 'listModels']);

// OTP
Route::post('resendCode', [OtpController::class, 'resendCode']);

// Client
Route::prefix('client')->group(function () {
    Route::post('/', [ClientController::class, 'store']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/', [ClientController::class, 'index'])
            ->middleware(['permission:read.client']);

        Route::get('read/{id}', [ClientController::class, 'show']);

        Route::middleware('is_client')->group(function () {
            Route::get('profile', [ClientController::class, 'profile']);
            Route::put('', [ClientController::class, 'update']);
        });

        Route::delete('{id}', [ClientController::class, 'destroy']);
    });
});

// Engineer
Route::prefix('engineer')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [EngineerController::class, 'index'])
        ->middleware(['permission:read.engineer']);

    Route::post('/', [EngineerController::class, 'store']);
    Route::get('{id}', [EngineerController::class, 'show']);

    Route::put('', [EngineerController::class, 'update']);
    Route::delete('{id}', [EngineerController::class, 'destroy']);
});

Route::prefix('project-engineer')->middleware('auth:sanctum')->group(function () {

    Route::post('allocate', [ProjectEngineerAllocationController::class, 'store'])
        ->middleware('permission:create.engineer');

    Route::get('/', [ProjectEngineerAllocationController::class, 'index'])
        ->middleware('permission:read.engineer');

    Route::get('/myLocations', [ProjectEngineerAllocationController::class, 'myLocations'])->middleware('is_engineer');

    Route::get('allocatedLocations/{engineer_id}', [ProjectEngineerAllocationController::class, 'engineerAllocations']);

    Route::get('engineersAllocatedToProject/{project_id}', [ProjectEngineerAllocationController::class, 'getEngineersAllocatedToProject']);
    Route::get('engineersAllocatedToBuilding/{building_id}', [ProjectEngineerAllocationController::class, 'getEngineersAllocatedToBuilding']);

    Route::put('{id}', [ProjectEngineerAllocationController::class, 'update']);
    Route::delete('{id}', [ProjectEngineerAllocationController::class, 'destroy']);
});

// Employee
Route::prefix('employee')->middleware('auth:sanctum')->group(function () {
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

    Route::post('assignRoles/{user_id}', [RoleController::class, 'assignRoles'])
        ->middleware(['permission:create.role']);

    # Search for role by id or name #
    Route::get('{id}', [RoleController::class, 'show'])
        ->middleware(['permission:read.role']);

    Route::get('name/{role_name}', [RoleController::class, 'showByName'])
        ->middleware(['permission:read.role']);

    # Manage Permissions for a role #
    Route::post('selectPermission/{role_id}', [RoleController::class, 'selectPermission'])
        ->middleware(['permission:update.role']);

    # Delete a role #
    Route::delete('{id}', [RoleController::class, 'destroy'])
        ->middleware(['permission:delete.role']);
});

Route::prefix('permission')->middleware('auth:sanctum')->group(function () {
    Route::get('', [PermissionController::class, 'index']);
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
    Route::post('assign/', [EmployeeDepartmentController::class, 'store'])
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

// Project
Route::prefix('project')->middleware(['auth:sanctum', 'is_staff'])->group(function () {
    Route::post('/', [ProjectController::class, 'store']);

    Route::put('{id}', [ProjectController::class, 'update']);

    Route::get('/', [ProjectController::class, 'index']);

    Route::get('{id}', [ProjectController::class, 'show']);

    Route::delete('{id}', [ProjectController::class, 'destroy']);
});

// Building
Route::prefix('building')->middleware(['auth:sanctum', 'is_staff'])->group(function () {
    Route::get('', [BuildingController::class, 'index']);

    Route::get('byProject/{project_id}', [BuildingController::class, 'byProject']);

    Route::post('/', [BuildingController::class, 'store']);

    Route::put('{id}', [BuildingController::class, 'update']);

    Route::get('{id}', [BuildingController::class, 'show']);

    Route::delete('{id}', [BuildingController::class, 'destroy']);
});

// Unit
Route::prefix('unit')->middleware(['auth:sanctum', 'is_staff'])->group(function () {
    Route::get('', [AdminUnitController::class, 'index']);

    Route::get('byBuilding/{building_id}', [AdminUnitController::class, 'byBuilding']);

    Route::post('/', [AdminUnitController::class, 'store']);

    Route::put('{id}', [AdminUnitController::class, 'update']);

    Route::get('search', [AdminUnitController::class, 'search']);

    Route::get('{id}', [AdminUnitController::class, 'show']);

    Route::delete('{id}', [AdminUnitController::class, 'destroy']);


    Route::prefix('sold')->group(function () {

        Route::get('unitOwnership', [UnitOwnershipController::class, 'index']);

        Route::get('clientUnits/{client_id}', [UnitOwnershipController::class, 'clientUnits']);

        Route::get('unitClient/{unit_id}', [UnitOwnershipController::class, 'clientUnits']);

        Route::put('update/{unit_id}', [UnitOwnershipController::class, 'update']);

        Route::delete('retrieve/{unit_id}', [UnitOwnershipController::class, 'destroy']);
    });
    Route::post('sale/{unit_id}', [UnitOwnershipController::class, 'store']);
});

Route::prefix('client')->middleware(['auth:sanctum', 'is_client'])->group(function () {
    Route::get('unit/read', [ClientUnitController::class, 'index']);

    Route::get('unit/read/getWithoutPag', [ClientUnitController::class, 'getWithoutPag']);

    Route::get('unit/byBuilding/{building_id}', [ClientUnitController::class, 'byBuilding']);

    Route::post('unit/search', [ClientUnitController::class, 'search']);

    Route::get('unit/{id}', [ClientUnitController::class, 'show']);

    Route::get('myUnits', [UnitOwnershipController::class, 'myUnits']);
});

Route::prefix('complaint')->middleware(['auth:sanctum'])->group(function () {
    Route::get('', [ComplaintController::class, 'index']);

    Route::get('client/myComplaints', [ComplaintController::class, 'myComplaints']);

    Route::get('clientComplaints/{client_id}', [ComplaintController::class, 'clientComplaints']);

    Route::post('', [ComplaintController::class, 'store']);

    Route::put('{id}', [ComplaintController::class, 'update']);

    Route::put('updateStatus/{id}', [ComplaintController::class, 'updateStatus']);

    Route::delete('{id}', [ComplaintController::class, 'destroy']);


    Route::get('type/read', [ComplaintTypeController::class, 'index']);

    Route::post('type/create', [ComplaintTypeController::class, 'store']);

    Route::delete('type/delete/{id}', [ComplaintTypeController::class, 'destroy']);
});

// Favorite
Route::prefix('favorite')->middleware(['auth:sanctum', 'is_client'])->group(function () {
    Route::get('my', [FavoriteController::class, 'index']);
    Route::post('{unit_id}', [FavoriteController::class, 'store']);
    Route::get('{id}', [FavoriteController::class, 'show']);
    Route::delete('{unit_id}', [FavoriteController::class, 'destroy']);
});

// Order
Route::prefix('order')->middleware('auth:sanctum')->group(function () {
    Route::middleware('is_staff')->group(function () {
        Route::get('/', [OrderController::class, 'index'])
            ->middleware(['permission:read.order']);

        Route::get('departmentOrders/{department_id}', [OrderController::class, 'departmentOrders'])
            ->middleware(['permission:read.order']);

        Route::get('getClientUnitOrders/{client_id}', [OrderController::class, 'clientUnitOrders'])
            ->middleware(['permission:read.order']);

        Route::get('getClientSolutionOrders/{client_id}', [OrderController::class, 'clientSolutionOrders'])
            ->middleware(['permission:read.order']);

        Route::post('note/add/{id}', [OrderController::class, 'addNote']);

        Route::put('changeStatus/{id}', [OrderController::class, 'changeStatus'])
            ->middleware(['permission:update.order']);

        Route::put('transfer/{id}', [OrderController::class, 'transfer'])
            ->middleware(['permission:update.order']);
    });

    Route::middleware('is_client')->group(function () {
        Route::get('myUnitOrders', [OrderController::class, 'myUnitOrders']);
        Route::get('mySolutionOrders', [OrderController::class, 'mySolutionOrders']);

        Route::post('/', [OrderController::class, 'store'])
            ->middleware(['permission:create.order']);
    });

    Route::get('{id}', [OrderController::class, 'show'])
        ->middleware(['permission:read.order']);

    Route::delete('{id}', [OrderController::class, 'destroy'])
        ->middleware(['permission:delete.order']);
});

Route::prefix('note')->group(function () {
    // ->middleware(['permission:update.order']);
    Route::put('{id}', [NoteController::class, 'update']);
    Route::delete('{id}', [NoteController::class, 'destroy']);
});

// Available slot
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

// Appointment
Route::prefix('appointment')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [AppointmentController::class, 'index'])
        ->middleware(['permission:read.appointment']);

    Route::post('/', [AppointmentController::class, 'store']);
    // ->middleware(['permission:create.appointment']);

    Route::get('{id}', [AppointmentController::class, 'show'])
        ->middleware(['permission:read.appointment']);

    Route::put('cancel/{id}', [AppointmentController::class, 'cancelAppointment'])
        ->middleware(['permission:update.appointment']);

    Route::put('markAsDone/{id}', [AppointmentController::class, 'markAsDone'])
        ->middleware(['permission:update.appointment']);

    Route::get('client/myAppointments', [AppointmentController::class, 'myAppointments']);
    // Route::post('askChangeTime/{id}', [AppointmentController::class, 'askChangeTime']);
});

// Advertisment
Route::prefix('advertisment')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [AdvertisementController::class, 'index'])
        ->middleware(['permission:create.advertisment']);

    Route::get('getActiveAdvertisements', [AdvertisementController::class, 'getActiveAdvertisements'])
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

Route::prefix('construction-report')->middleware('auth:sanctum')->group(function () {

    Route::get('/myReports/{project_id?}', [ConstructionReportController::class, 'myReports'])
        ->middleware(['permission:read.report', 'is_engineer']);

    Route::post('/', [ConstructionReportController::class, 'store'])
        ->middleware(['permission:create.report', 'is_engineer']);

    Route::get('/', [ConstructionReportController::class, 'index'])
        ->middleware(['permission:read.report', 'is_staff']);

    Route::get('/{id}', [ConstructionReportController::class, 'show'])
        ->middleware(['permission:read.report']);

    Route::delete('/{id}', [ConstructionReportController::class, 'destroy'])
        ->middleware(['permission:delete.report']);

    Route::post('/{uuid}/attach-images', [ConstructionReportController::class, 'uploadImages'])->middleware('is_engineer');
});

Route::prefix('attendance')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [AttendanceController::class, 'index'])
        ->middleware(['permission:read.attendance']);

    Route::post('/check-in', [AttendanceController::class, 'storeCheckIn'])
        ->middleware(['permission:create.attendance', 'is_engineer']);

    Route::post('/check-out', [AttendanceController::class, 'storeCheckOut'])
        ->middleware(['permission:create.attendance', 'is_engineer']);

    Route::get('{id}', [AttendanceController::class, 'show'])
        ->middleware(['permission:read.attendance']);

    Route::put('{id}', [AttendanceController::class, 'update'])
        ->middleware(['permission:update.attendance']);

    Route::delete('{id}', [AttendanceController::class, 'destroy'])
        ->middleware(['permission:delete.attendance']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('chat')->group(function () {
        Route::get('/rooms', [ChatController::class, 'index']);
        Route::post('/rooms', [ChatController::class, 'createRoom'])->middleware('is_client');

        Route::post('/message', [ChatController::class, 'store']);
        Route::get('/rooms/{roomId}/messages', [ChatController::class, 'getMessages']);

        Route::middleware('is_staff')->group(function () {
            Route::get('/unassigned', [ChatController::class, 'unassignedRooms']);
            Route::post('/rooms/{roomId}/claim', [ChatController::class, 'claim']);
        });
    });

    Broadcast::routes(['middleware' => ['auth:sanctum']]);
});

Route::prefix('lottery')->middleware(['auth:sanctum', 'is_staff'])->group(function () {
    Route::get('', [LotteryController::class, 'index']);
    Route::get('{id}', [LotteryController::class, 'show']);
    Route::post('', [LotteryController::class, 'store']);
    Route::put('{id}', [LotteryController::class, 'update']);
    Route::delete('{id}', [LotteryController::class, 'destroy']);

    Route::put('cancel/{id}', [LotteryController::class, 'cancel']);
    Route::put('drawWinner/{id}', [LotteryController::class, 'drawWinner']);
});

Route::prefix('offer')->middleware(['auth:sanctum', 'is_staff'])->group(function () {
    Route::get('', [AdminOfferController::class, 'index']);
    Route::get('{id}', [AdminOfferController::class, 'show']);
    Route::get('', [AdminOfferController::class, 'activeOffers']);
    Route::post('', [AdminOfferController::class, 'store']);
    Route::put('{id}', [AdminOfferController::class, 'update']);
    Route::delete('{id}', [AdminOfferController::class, 'destroy']);
});

Route::get('offer/client', [ClientOfferController::class, 'activeOffers']);
Route::get('offer/client/{id}', [ClientOfferController::class, 'show']);

Route::get('/run-seeder', function () {
    Artisan::call('migrate:fresh', [
        '--seed' => true,
        '--force' => true,
    ]);
    return 'Database has been refreshed and seeded!';
});


Route::get('/queue', function () {
    Artisan::call('queue:work');
});
