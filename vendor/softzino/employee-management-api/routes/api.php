<?php
use Illuminate\Support\Facades\Route;
use Softzino\EmployeeManagementApi\Http\Controllers\DesignationController;
use Softzino\EmployeeManagementApi\Http\Controllers\EmployeeController;
use Softzino\EmployeeManagementApi\Http\Controllers\DepartmentController;

Route::prefix('api')->group(function () {
    Route::prefix('employees')->group(function () {
        Route::get('/', [EmployeeController::class, 'index']); // GET /employees
        Route::get('{id}', [EmployeeController::class, 'show']); // GET /employees/{id}
        Route::put('{id}/status', [EmployeeController::class, 'updateStatus']); // PUT /employees/{id}/status
    });

    Route::prefix('departments')->group(function () {
        Route::get('/list', [DepartmentController::class, 'index']);
    });

    Route::prefix('designations')->group(function () {
        Route::get('/', [DesignationController::class, 'index']);
        Route::get('{id}', [DesignationController::class, 'show']);
        Route::put('{designation}/toggle-status', [DesignationController::class, 'toggleStatus']);
    });
});
