<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Simple test route
Route::get('/test-simple', function () {
    return 'Simple route works';
});

// Test admin route
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/test-admin', function () {
        return 'Admin route works';
    });
    
    Route::get('/patients/create', [AdminController::class, 'createPatient'])->name('patients.create');
    Route::get('/doctors/create', [AdminController::class, 'createDoctor'])->name('doctors.create');
});
