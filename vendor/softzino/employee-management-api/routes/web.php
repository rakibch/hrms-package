<?php

use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use Softzino\EmployeeManagementApi\Http\Controllers\Web\Department\IndexDepartmentController;
use Softzino\EmployeeManagementApi\Http\Controllers\Web\Department\ShowDepartmentController;
use Softzino\EmployeeManagementApi\Http\Controllers\Web\Department\StoreDepartmentController;
use Softzino\EmployeeManagementApi\Http\Controllers\Web\Department\UpdateDepartmentController;
use Softzino\EmployeeManagementApi\Http\Controllers\Web\Department\ToggleDepartmentStatusController;

use Softzino\EmployeeManagementApi\Http\Controllers\Web\Designation\IndexDesignationController;
use Softzino\EmployeeManagementApi\Http\Controllers\Web\Designation\StoreDesignationController;
use Softzino\EmployeeManagementApi\Http\Controllers\Web\Designation\UpdateDesignationController;
use Softzino\EmployeeManagementApi\Http\Controllers\Web\Designation\ShowDesignationController;
use Softzino\EmployeeManagementApi\Http\Controllers\Web\Designation\UpdateDesignationStatusController;

use Softzino\EmployeeManagementApi\Http\Controllers\Web\Employee\Create;
use Softzino\EmployeeManagementApi\Http\Controllers\Web\Document\Delete;
use Softzino\EmployeeManagementApi\Http\Controllers\Web\Employee\Edit;
use Softzino\EmployeeManagementApi\Http\Controllers\Web\Employee\Index;
use Softzino\EmployeeManagementApi\Http\Controllers\Web\Employee\Show;
use Softzino\EmployeeManagementApi\Http\Controllers\Web\Employee\Store;
use Softzino\EmployeeManagementApi\Http\Controllers\Web\Employee\Timeline;
use Softzino\EmployeeManagementApi\Http\Controllers\Web\Employee\Update;
use Softzino\EmployeeManagementApi\Http\Controllers\Web\Employee\UpdateStatus;
use Softzino\EmployeeManagementApi\Http\Controllers\Web\Employee\View;


// Department routes
Route::prefix('departments')->name('departments.')->group(function () {
    Route::get('/', IndexDepartmentController::class)->name('index');
    Route::post('/', StoreDepartmentController::class)->middleware(HandlePrecognitiveRequests::class)->name('store');
    Route::get('/{id}', ShowDepartmentController::class)->name('show');
    Route::post('/{department}', UpdateDepartmentController::class)->name('update');
    Route::get('/{department}/toggle-status', ToggleDepartmentStatusController::class)->name('toggle-status');
});

    // Designation routes
    Route::prefix('designations')->name('designations.')->group(function () {
        Route::get('/', IndexDesignationController::class)->name('index');
        Route::post('/', StoreDesignationController::class)->name('store');
        Route::get('/{id}', ShowDesignationController::class)->name('show');
        Route::post('/{designation}', UpdateDesignationController::class)->name('update');
        Route::get('/{designation}/toggle-status', UpdateDesignationStatusController::class)->name('update.status');
    });


Route::prefix('employee')->name('employee.')->group(function () {
    Route::get('/', Index::class)->name('index');
    Route::get('/create', Create::class)->name('create');
    Route::post('/', Store::class)->middleware(HandlePrecognitiveRequests::class)->name('store');
    Route::get('/{id}', Show::class)->name('show');
    Route::get('/{id}/edit', Edit::class)->name('edit');
    Route::post("/{employee}", Update::class)->name('update');
    Route::get('/{employee}/view-information',View::class)->name('view.information');
    Route::post('/{employee}/update-status', UpdateStatus::class)->name('update.status');
    Route::get('/{employee}/employee-timeline', Timeline::class)->name('timeline');
});

Route::prefix('document')->name('document.')->group(function (){
    Route::post('/{id}',Delete::class)->name('delete');
});

