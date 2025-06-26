<?php
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

try {
    // Bootstrap the application
    $kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    
    // Check current database state
    echo "Current database state:\n";
    echo "Roles: " . \App\Models\Role::count() . "\n";
    echo "Users: " . \App\Models\User::count() . "\n";
    echo "Doctors: " . \App\Models\Doctor::count() . "\n";
    echo "Patients: " . \App\Models\Patient::count() . "\n";
    echo "Test Categories: " . \App\Models\TestCategory::count() . "\n";
    echo "Tests: " . \App\Models\Test::count() . "\n";
    echo "Packages: " . \App\Models\Package::count() . "\n";
    echo "Associates: " . \App\Models\Associate::count() . "\n";
    echo "Reports: " . \App\Models\Report::count() . "\n";
    echo "Report Tests: " . \App\Models\ReportTest::count() . "\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
