<?php
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

try {
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    
    $router = $app->make('router');
    $routes = $router->getRoutes();
    
    echo "Looking for patient routes...\n";
    foreach ($routes as $route) {
        $name = $route->getName();
        if ($name && str_contains($name, 'patients')) {
            echo "Route: {$name} -> {$route->uri()}\n";
        }
    }
    
    // Check if the specific route exists
    try {
        $url = route('admin.patients.create');
        echo "\nRoute 'admin.patients.create' resolves to: {$url}\n";
    } catch (Exception $e) {
        echo "\nError resolving 'admin.patients.create': " . $e->getMessage() . "\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
