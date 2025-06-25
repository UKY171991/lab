<?php

require_once 'vendor/autoload.php';

use App\Models\TestCategory;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Validation\Rule;

$app = require_once 'bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

echo "Debug Validation Rule:\n";
echo "=====================\n";

try {
    // Get existing BIOCHEMISTRY category
    $biochemistry = TestCategory::where('category_name', 'BIOCHEMISTRY')->first();
    
    if ($biochemistry) {
        echo "Testing with category ID: {$biochemistry->id}\n";
        echo "Category name: {$biochemistry->category_name}\n\n";
        
        // Test the Rule::unique method directly
        $rule = Rule::unique('test_categories', 'category_name')->ignore($biochemistry->id);
        
        echo "Generated rule object: " . get_class($rule) . "\n";
        
        // Create validator instance
        $validator = \Illuminate\Support\Facades\Validator::make([
            'category_name' => 'BIOCHEMISTRY',
        ], [
            'category_name' => ['required', 'string', 'max:255', $rule],
        ]);
        
        echo "Validation data: " . json_encode($validator->getData()) . "\n";
        echo "Validation rules: " . json_encode($validator->getRules()) . "\n";
        
        if ($validator->passes()) {
            echo "✅ Validation PASSED\n";
        } else {
            echo "❌ Validation FAILED: " . implode(', ', $validator->errors()->all()) . "\n";
            
            // Try with different ID format
            echo "\nTrying with string ID...\n";
            $rule2 = Rule::unique('test_categories', 'category_name')->ignore((string)$biochemistry->id);
            $validator2 = \Illuminate\Support\Facades\Validator::make([
                'category_name' => 'BIOCHEMISTRY',
            ], [
                'category_name' => $rule2,
            ]);
            
            if ($validator2->passes()) {
                echo "✅ Validation PASSED with string ID\n";
            } else {
                echo "❌ Still failed with string ID\n";
            }
            
            // Try manual query to check what's happening
            echo "\nManual database check:\n";
            $existing = TestCategory::where('category_name', 'BIOCHEMISTRY')
                                  ->where('id', '!=', $biochemistry->id)
                                  ->first();
            
            if ($existing) {
                echo "Found other record with same name: ID {$existing->id}\n";
            } else {
                echo "No other records found with same name\n";
            }
        }
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
