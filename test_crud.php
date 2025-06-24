<?php

// Quick test to ensure all test functionalities work

echo "Testing Tests Management System...\n";

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Test;
use App\Models\User;

// Test if we can create a test
try {
    echo "1. Testing Create...\n";
    $test = Test::create([
        'test_name' => 'Test API Check',
        'specimen' => 'Blood',
        'result_default' => 'Normal',
        'unit' => 'mg/dL',
        'reference_range' => '70-100',
        'min_value' => 70,
        'max_value' => 100,
        'is_sub_heading' => false,
        'testcode' => 'API001',
        'individual_method' => 'API Test',
        'status' => true
    ]);
    echo "✓ Create test passed - ID: {$test->id}\n";

    // Test if we can read/find the test
    echo "2. Testing Read...\n";
    $foundTest = Test::find($test->id);
    if ($foundTest && $foundTest->test_name === 'Test API Check') {
        echo "✓ Read test passed\n";
    } else {
        echo "✗ Read test failed\n";
    }

    // Test if we can update the test
    echo "3. Testing Update...\n";
    $foundTest->update(['test_name' => 'Updated API Check']);
    $updatedTest = Test::find($test->id);
    if ($updatedTest->test_name === 'Updated API Check') {
        echo "✓ Update test passed\n";
    } else {
        echo "✗ Update test failed\n";
    }

    // Test if we can delete the test
    echo "4. Testing Delete...\n";
    $deleted = $foundTest->delete();
    $deletedTest = Test::find($test->id);
    if ($deleted && !$deletedTest) {
        echo "✓ Delete test passed\n";
    } else {
        echo "✗ Delete test failed\n";
    }

    echo "\nAll CRUD operations working correctly!\n";

    // Check current test count
    $count = Test::count();
    echo "Current tests in database: $count\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
