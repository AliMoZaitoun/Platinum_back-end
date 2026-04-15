<?php

use App\Http\Controllers\V1\OfferingController;
use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\ClientController;
use App\Http\Controllers\V1\EmployeeController;
use App\Http\Controllers\V1\EngineerController;
use App\Http\Controllers\V1\ItemController;
use App\Http\Controllers\V1\OtpController;
use App\Http\Controllers\V1\PermissionController;
use App\Http\Controllers\V1\RoleController;
use App\Http\Controllers\V1\WarehouseController;
use Illuminate\Support\Facades\Route;

// Auth
Route::post('verifyEmail', [AuthController::class, 'verifyEmail']);
Route::post('login', [AuthController::class, 'login']);
Route::post('changePassword', [AuthController::class, 'changePassword'])->middleware('auth:sanctum');
Route::post('forgotPassword', [AuthController::class, 'forgotPassword']);
Route::post('resetPassword', [AuthController::class, 'resetPassword']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// OTP
Route::post('resendCode/{userId}', [OtpController::class, 'resendCode']);

// Client
Route::prefix('client')->group(function () {
    Route::post('register', [ClientController::class, 'registerClient']);
    Route::get('{id}', [ClientController::class, 'getClient']);
    Route::put('update', [ClientController::class, 'updateClient'])->middleware('auth:sanctum');
});

// Engineer
Route::prefix('engineer')->group(function () {
    Route::post('register', [EngineerController::class, 'registerEngineer']);
    Route::get('{id}', [EngineerController::class, 'getEngineer']);
    Route::put('update', [EngineerController::class, 'updateEngineer'])->middleware('auth:sanctum');
});

// Employee
Route::prefix('employee')->group(function () {
    Route::post('register', [EmployeeController::class, 'registerEmployee']);
    Route::get('{id}', [EmployeeController::class, 'getEmployee']);
    Route::put('update', [EmployeeController::class, 'updateEmployee'])->middleware('auth:sanctum');
});

// Warehouse
Route::prefix('warehouse')->group(function () {
    Route::post('/', [WarehouseController::class, 'createWarehouse'])
        ->middleware(['auth:sanctum', 'permission:create warehouse']);

    Route::put('{warehouse_id}', [WarehouseController::class, 'updateWarehouse']);
    Route::get('/', [WarehouseController::class, 'getAllWarehouses']);
    Route::get('{warehouse_id}', [WarehouseController::class, 'getWarehouseById']);
    Route::delete('{warehouse_id}', [WarehouseController::class, 'deleteWarehouse']);

    // Item
    Route::prefix('item')->group(function () {
        Route::post('/', [ItemController::class, 'addItem']);
        Route::put('{item_id}', [ItemController::class, 'updateItem']);
        Route::get('/', [ItemController::class, 'getAllItems']);
        Route::get('warehouse/{warehouse_id}', [ItemController::class, 'getItemsByWarehouseID']);
        Route::get('{item_id}', [ItemController::class, 'getItemById']);
        Route::delete('{item_id}', [ItemController::class, 'deleteItem']);
    });
});

// Offering
Route::prefix('offering')->group(function () {
    Route::post('/', [OfferingController::class, 'createOffering']);
    Route::put('{offering_id}', [OfferingController::class, 'updateOffering']);
    Route::get('/', [OfferingController::class, 'getAllOfferings']);
    Route::get('{offering_id}', [OfferingController::class, 'getOfferingByID']);
    Route::delete('{offering_id}', [OfferingController::class, 'deleteOffering']);
});

// Role
Route::prefix('role')->group(function () {
    Route::post('/', [RoleController::class, 'createRole']);
    Route::put('{role_id}', [RoleController::class, 'updateRole']);
    Route::get('/', [RoleController::class, 'getRoles']);
    Route::get('{role_id}', [RoleController::class, 'getRoleById']);
    Route::get('name/{role_name}', [RoleController::class, 'getRoleByName']);
    Route::delete('{role_id}', [RoleController::class, 'deleteRole']);
});

// Permission
Route::prefix('permission')->group(function () {
    Route::post('/', [PermissionController::class, 'createPermission']);
    Route::put('{permission_id}', [PermissionController::class, 'updatePermission']);
    Route::get('/', [PermissionController::class, 'getPermissions']);
    Route::get('{permission_id}', [PermissionController::class, 'getPermissionById']);
    Route::get('name/{permission_name}', [PermissionController::class, 'getPermissionByName']);
    Route::delete('{permission_id}', [PermissionController::class, 'deletePermission']);
});
