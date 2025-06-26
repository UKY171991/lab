<?php
echo "Testing seeding process...\n";

// Include Laravel bootstrap
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

try {
    // Bootstrap the application
    $kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    
    echo "Laravel bootstrapped successfully\n";
    
    // Run seeders using Artisan programmatically
    \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'RoleSeeder']);
    echo "RoleSeeder completed\n";
    
    \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'DoctorSeeder']);
    echo "DoctorSeeder completed\n";
    
    \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'PatientSeeder']);
    echo "PatientSeeder completed\n";
    
    \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'TestCategorySeeder']);
    echo "TestCategorySeeder completed\n";
    
    \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'TestSeeder']);
    echo "TestSeeder completed\n";
    
    \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'PackageSeeder']);
    echo "PackageSeeder completed\n";
    
    \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'AssociateSeeder']);
    echo "AssociateSeeder completed\n";
    
    \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'ReportSeeder']);
    echo "ReportSeeder completed\n";
    
    \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'ReportTestSeeder']);
    echo "ReportTestSeeder completed\n";
    
    // Create users
    \App\Models\User::factory(100)->create();
    echo "100 users created\n";
    
    // Display counts
    echo "\nFinal counts:\n";
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
    
    echo "\nSeeding completed successfully!\n";
    
} catch (Exception $e) {
    echo "Error occurred: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
}
