<?php

require_once 'vendor/autoload.php';

use App\Models\TestCategory;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;

$app = require_once 'bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

echo "Checking for duplicate categories:\n";
echo "=================================\n";

try {
    $duplicates = TestCategory::where('category_name', 'BIOCHEMISTRY')->get();
    
    echo "Found " . $duplicates->count() . " BIOCHEMISTRY records:\n";
    foreach ($duplicates as $cat) {
        echo "ID: {$cat->id}, Name: {$cat->category_name}, Created: {$cat->created_at}\n";
    }
    
    if ($duplicates->count() > 1) {
        echo "\n🔧 FIXING: Removing duplicate records...\n";
        
        // Keep the first one, delete the rest
        $first = $duplicates->first();
        $duplicatesToDelete = $duplicates->skip(1);
        
        foreach ($duplicatesToDelete as $duplicate) {
            echo "Deleting duplicate ID: {$duplicate->id}\n";
            $duplicate->delete();
        }
        
        echo "✅ Duplicates removed. Kept record ID: {$first->id}\n";
    }
    
    // Check for other potential duplicates
    echo "\nChecking for other duplicates:\n";
    $categories = TestCategory::selectRaw('category_name, COUNT(*) as count')
                             ->groupBy('category_name')
                             ->having('count', '>', 1)
                             ->get();
    
    if ($categories->count() > 0) {
        echo "Found other duplicates:\n";
        foreach ($categories as $cat) {
            echo "- {$cat->category_name}: {$cat->count} records\n";
        }
        
        // Fix all duplicates
        foreach ($categories as $cat) {
            $dups = TestCategory::where('category_name', $cat->category_name)->get();
            $first = $dups->first();
            $toDelete = $dups->skip(1);
            
            foreach ($toDelete as $dup) {
                echo "Deleting duplicate '{$cat->category_name}' ID: {$dup->id}\n";
                $dup->delete();
            }
        }
        echo "✅ All duplicates cleaned up\n";
    } else {
        echo "No other duplicates found.\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
