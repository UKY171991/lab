<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [AdminController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');

    // AJAX routes for User Management
    Route::get('/users/data', [AdminController::class, 'getUsers'])->name('users.data');
    Route::post('/users', [AdminController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [AdminController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'destroy'])->name('users.destroy');

    // Master Menu Routes
    Route::get('/tests', [AdminController::class, 'tests'])->name('tests');
    Route::get('/tests/data', [AdminController::class, 'getTests'])->name('tests.data');
    Route::post('/tests', [AdminController::class, 'storeTest'])->name('tests.store');
    Route::get('/tests/{test}/edit', [AdminController::class, 'editTest'])->name('tests.edit');
    Route::delete('/tests/{test}', [AdminController::class, 'destroyTest'])->name('tests.destroy');
    
    // Doctor Management Routes
    Route::get('/doctors', [AdminController::class, 'doctors'])->name('doctors');
    Route::get('/doctors/data', [AdminController::class, 'getDoctors'])->name('doctors.data');
    Route::post('/doctors', [AdminController::class, 'storeDoctor'])->name('doctors.store');
    Route::get('/doctors/{doctor}/edit', [AdminController::class, 'editDoctor'])->name('doctors.edit');
    Route::delete('/doctors/{doctor}', [AdminController::class, 'destroyDoctor'])->name('doctors.destroy');
    
    // Patient Management Routes
    Route::get('/patients', [AdminController::class, 'patients'])->name('patients');
    Route::get('/patients/data', [AdminController::class, 'getPatients'])->name('patients.data');
    Route::post('/patients', [AdminController::class, 'storePatient'])->name('patients.store');
    Route::get('/patients/{patient}/edit', [AdminController::class, 'editPatient'])->name('patients.edit');
    Route::delete('/patients/{patient}', [AdminController::class, 'destroyPatient'])->name('patients.destroy');
    
    // Package Management Routes
    Route::get('/packages', [AdminController::class, 'packages'])->name('packages');
    Route::get('/packages/data', [AdminController::class, 'getPackages'])->name('packages.data');
    Route::post('/packages', [AdminController::class, 'storePackage'])->name('packages.store');
    Route::get('/packages/{package}/edit', [AdminController::class, 'editPackage'])->name('packages.edit');
    Route::delete('/packages/{package}', [AdminController::class, 'destroyPackage'])->name('packages.destroy');
    
    // Test Category Management Routes
    Route::get('/test-categories', [AdminController::class, 'testCategories'])->name('test-categories');
    Route::get('/test-categories/data', [AdminController::class, 'getTestCategories'])->name('test-categories.data');
    Route::post('/test-categories', [AdminController::class, 'storeTestCategory'])->name('test-categories.store');
    Route::get('/test-categories/{category}/edit', [AdminController::class, 'editTestCategory'])->name('test-categories.edit');
    Route::delete('/test-categories/{category}', [AdminController::class, 'destroyTestCategory'])->name('test-categories.destroy');
    
    // Associate Management Routes
    Route::get('/associates', [AdminController::class, 'associates'])->name('associates');
    Route::get('/associates/data', [AdminController::class, 'getAssociates'])->name('associates.data');
    Route::post('/associates', [AdminController::class, 'storeAssociate'])->name('associates.store');
    Route::get('/associates/{associate}/edit', [AdminController::class, 'editAssociate'])->name('associates.edit');
    Route::delete('/associates/{associate}', [AdminController::class, 'destroyAssociate'])->name('associates.destroy');
    Route::get('/associates/test', [AdminController::class, 'testAssociatesData'])->name('associates.test');

    // Entry Routes
    Route::prefix('entry')->name('entry.')->group(function () {
        Route::get('/entry-list', [AdminController::class, 'entryList'])->name('entry-list');
        Route::get('/test-booking', [AdminController::class, 'testBooking'])->name('test-booking');
        Route::get('/sample-collection', [AdminController::class, 'sampleCollection'])->name('sample-collection');
        Route::get('/result-entry', [AdminController::class, 'resultEntry'])->name('result-entry');
    });

    // Settings update routes
    Route::post('/settings/general', [AdminController::class, 'updateGeneralSettings'])->name('settings.general.update');
    Route::post('/settings/system', [AdminController::class, 'updateSystemSettings'])->name('settings.system.update');
    Route::post('/settings/email', [AdminController::class, 'updateEmailSettings'])->name('settings.email.update');
    Route::post('/settings/security', [AdminController::class, 'updateSecuritySettings'])->name('settings.security.update');
    Route::post('/settings/appearance', [AdminController::class, 'updateAppearanceSettings'])->name('settings.appearance.update');
    
    // Settings utility routes
    Route::post('/settings/test-email', [AdminController::class, 'testEmailConnection'])->name('settings.test-email');
    Route::post('/settings/clear-cache', [AdminController::class, 'clearCache'])->name('settings.clear-cache');
    Route::post('/settings/backup/create', [AdminController::class, 'createBackup'])->name('settings.backup.create');
    Route::get('/settings/backup/download', [AdminController::class, 'downloadBackup'])->name('settings.backup.download');
    Route::delete('/settings/backup/delete', [AdminController::class, 'deleteBackup'])->name('settings.backup.delete');
    Route::post('/settings/backup/restore', [AdminController::class, 'restoreBackup'])->name('settings.backup.restore');

    // Reports Management Routes
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    Route::get('/reports/create', [AdminController::class, 'createReport'])->name('reports.create');
    Route::post('/reports', [AdminController::class, 'storeReport'])->name('reports.store');
    Route::get('/reports/{id}', [AdminController::class, 'showReport'])->name('reports.show');
    Route::get('/reports/{id}/edit', [AdminController::class, 'editReport'])->name('reports.edit');
    Route::put('/reports/{id}', [AdminController::class, 'updateReport'])->name('reports.update');
    Route::delete('/reports/{id}', [AdminController::class, 'destroyReport'])->name('reports.destroy');
    Route::get('/reports/{id}/print', [AdminController::class, 'printReport'])->name('reports.print');
    Route::get('/reports/data', [AdminController::class, 'getReports'])->name('reports.data');

    // Test endpoint for debugging
    Route::get('/test-endpoint', function() {
        return response()->json(['message' => 'Test endpoint working', 'user' => auth()->user()]);
    });
});

// Test route without auth
Route::get('/test-page', function() {
    return view('admin.test-page');
});

// Auto-login route for testing
Route::get('/auto-login', function() {
    $user = \App\Models\User::where('email', 'admin@lab.com')->first();
    if ($user) {
        auth()->login($user);
        return redirect('/admin/tests');
    }
    return 'Admin user not found';
});

require __DIR__.'/auth.php';
