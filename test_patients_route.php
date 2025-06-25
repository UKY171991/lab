<?php

require_once 'vendor/autoload.php';

use App\Models\Patient;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;

$app = require_once 'bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

echo "Testing Patients Data:\n";
echo "===================\n";

try {
    $patients = Patient::select('id', 'client_name', 'mobile_number', 'uhid', 'sex', 'age', 'status', 'created_at')
                      ->orderBy('created_at', 'desc')
                      ->take(5)
                      ->get();
    
    echo "Total patients: " . Patient::count() . "\n\n";
    
    if ($patients->count() > 0) {
        echo "Sample patients:\n";
        foreach ($patients as $patient) {
            echo "ID: {$patient->id}\n";
            echo "Name: {$patient->client_name}\n";
            echo "Mobile: {$patient->mobile_number}\n";
            echo "UHID: {$patient->uhid}\n";
            echo "Sex: {$patient->sex}\n";
            echo "Age: {$patient->age}\n";
            echo "Status: " . ($patient->status ? 'Active' : 'Inactive') . "\n";
            echo "Created: {$patient->created_at}\n";
            echo "---\n";
        }
    } else {
        echo "No patients found.\n";
    }
    
    // Test the DataTables response format
    echo "\nTesting DataTables response format:\n";
    echo "===================================\n";
    
    $data = Patient::select('patients.*')->orderBy('created_at', 'desc')->take(3)->get();
    
    foreach ($data as $row) {
        echo "Patient: {$row->client_name}\n";
        echo "Status Badge: " . ($row->status ? 
            '<span class="badge badge-success"><i class="fas fa-check-circle"></i> Active</span>' : 
            '<span class="badge badge-danger"><i class="fas fa-times-circle"></i> Inactive</span>') . "\n";
        
        $color = $row->sex === 'Male' ? 'primary' : ($row->sex === 'Female' ? 'pink' : 'secondary');
        echo "Sex Badge: " . ($row->sex ? '<span class="badge badge-' . $color . '">' . $row->sex . '</span>' : 'N/A') . "\n";
        
        echo "Age Display: " . ($row->age ? $row->age . ' years' : 'N/A') . "\n";
        echo "Created Formatted: " . ($row->created_at ? $row->created_at->format('d M Y') : 'N/A') . "\n";
        echo "---\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
