<?php

// Simple route test without Laravel framework
echo "Testing route configuration...\n";

// Read the routes file and check if it's valid PHP
$routesFile = 'routes/web.php';
if (file_exists($routesFile)) {
    echo "Routes file exists\n";
    
    $content = file_get_contents($routesFile);
    
    // Check for the specific route we need
    if (strpos($content, "Route::get('/patients/create'") !== false) {
        echo "✓ Found patients/create route definition\n";
    } else {
        echo "✗ Missing patients/create route definition\n";
    }
    
    if (strpos($content, "admin.patients.create") !== false) {
        echo "✓ Found admin.patients.create route name\n";
    } else {
        echo "✗ Missing admin.patients.create route name\n";
    }
    
    // Check for syntax errors by trying to include the file
    ob_start();
    $error = false;
    try {
        include $routesFile;
    } catch (ParseError $e) {
        $error = true;
        echo "✗ Syntax error in routes file: " . $e->getMessage() . "\n";
    } catch (Error $e) {
        $error = true;
        echo "✗ Error in routes file: " . $e->getMessage() . "\n";
    }
    ob_end_clean();
    
    if (!$error) {
        echo "✓ Routes file syntax is valid\n";
    }
    
} else {
    echo "✗ Routes file not found\n";
}
