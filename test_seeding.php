<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    echo "Starting database seeding...\n";
    
    // Test basic connection
    $count = \App\Models\User::count();
    echo "Current users count: $count\n";
    
    // Run a simple seeder
    $seeder = new \Database\Seeders\RoleSeeder();
    $seeder->run();
    echo "RoleSeeder completed\n";
    
    $roleCount = \App\Models\Role::count();
    echo "Roles created: $roleCount\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
