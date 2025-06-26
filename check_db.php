<?php
require_once 'vendor/autoload.php';

try {
    $app = require_once 'bootstrap/app.php';
    $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
    
    echo "Testing database connection...\n";
    
    // Test basic DB connection
    $pdo = new PDO('sqlite:' . __DIR__ . '/database/database.sqlite');
    
    // List all tables
    $stmt = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' ORDER BY name");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "Tables in database:\n";
    foreach ($tables as $table) {
        echo "- $table\n";
    }
    
    // Check if reports table exists
    if (in_array('reports', $tables)) {
        echo "\n✓ Reports table exists!\n";
        
        // Count reports
        $stmt = $pdo->query("SELECT COUNT(*) FROM reports");
        $count = $stmt->fetchColumn();
        echo "Reports count: $count\n";
    } else {
        echo "\n✗ Reports table does not exist!\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
