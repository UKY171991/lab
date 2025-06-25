<?php

require_once 'vendor/autoload.php';

use App\Models\TestCategory;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;

$app = require_once 'bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

echo "Testing Test Categories Fix:\n";
echo "===========================\n";

try {
    // Test 1: Get existing BIOCHEMISTRY category
    $biochemistry = TestCategory::where('category_name', 'BIOCHEMISTRY')->first();
    
    if ($biochemistry) {
        echo "Found BIOCHEMISTRY category with ID: {$biochemistry->id}\n";
        echo "Name: {$biochemistry->category_name}\n";
        echo "Description: {$biochemistry->description}\n";
        echo "Status: " . ($biochemistry->status ? 'Active' : 'Inactive') . "\n";
        echo "Created: {$biochemistry->created_at}\n\n";
          // Test 2: Simulate the validation that was failing
        echo "Testing validation fix:\n";
        echo "----------------------\n";
        
        // This should now work for updates
        $validator = \Illuminate\Support\Facades\Validator::make([
            'category_name' => 'BIOCHEMISTRY',
            'description' => 'Updated description'
        ], [
            'category_name' => ['required', 'string', 'max:255', \Illuminate\Validation\Rule::unique('test_categories', 'category_name')->ignore($biochemistry->id)],
            'description' => ['nullable', 'string']
        ]);
        
        if ($validator->passes()) {
            echo "✅ Validation PASSED - Update with same name should work\n";
        } else {
            echo "❌ Validation FAILED - " . implode(', ', $validator->errors()->all()) . "\n";
        }
        
        // Test 3: Test creating a duplicate (should fail)
        $validator2 = \Illuminate\Support\Facades\Validator::make([
            'category_name' => 'BIOCHEMISTRY',
            'description' => 'Duplicate category'
        ], [
            'category_name' => ['required', 'string', 'max:255', 'unique:test_categories,category_name'],
            'description' => ['nullable', 'string']
        ]);
        
        if ($validator2->fails()) {
            echo "✅ Validation correctly FAILED for duplicate name - " . implode(', ', $validator2->errors()->all()) . "\n";
        } else {
            echo "❌ Validation should have failed for duplicate name\n";
        }
        
    } else {
        echo "BIOCHEMISTRY category not found. Let's check what categories exist:\n";
        $categories = TestCategory::take(5)->get();
        foreach ($categories as $cat) {
            echo "- {$cat->category_name} (ID: {$cat->id})\n";
        }
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}

echo "\nTest completed!\n";
