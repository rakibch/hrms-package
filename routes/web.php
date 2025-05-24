<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');

//    // Employee routes
//    Route::prefix('employee')->name('employee.')->group(function () {
//        // General employee routes
//        Route::get('/', IndexEmployeeController::class)->name('index');
//        Route::get('/create', CreateEmployeeController::class)->name('create');
//        Route::get('/{employee}', ShowEmployeeController::class)->name('show');
//        Route::delete('/{employee}', DestroyEmployeeController::class)->name('destroy');
//        Route::post('/{employee}/update-status', UpdateEmployeeStatusController::class)->name('update.status');
//        Route::get('/{employee}/view-information',ViewInfoEmployeeController::class)->name('view.information');
//        Route::get('/{employee}/employee-timeline',TimelineController::class)->name('timeline');
//
//        // Unified store and update routes for employee creation steps
//        Route::post('/', StoreEmployeeController::class)->middleware(HandlePrecognitiveRequests::class)->name('store');
//        Route::put('/{employee}', UpdateEmployeeController::class)->name('update');
//    });
});

// Authentication routes test
require __DIR__.'/auth.php';
