<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

try {
    $columns = Schema::getColumnListing('tests');
    echo "Table 'tests' columns:\n";
    foreach ($columns as $column) {
        echo "- $column\n";
    }
    
    echo "\nFirst test record:\n";
    $test = DB::table('tests')->first();
    if ($test) {
        print_r($test);
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
