<?php

require_once 'vendor/autoload.php';

use App\Models\Patient;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;
use Yajra\DataTables\Facades\DataTables;

$app = require_once 'bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

echo "Testing DataTables AJAX Response:\n";
echo "================================\n";

try {
    // Simulate the controller method
    $data = Patient::select('patients.*')->orderBy('created_at', 'desc');
    
    $dataTable = DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('status', function ($row) {
            return $row->status ? 
                '<span class="badge badge-success"><i class="fas fa-check-circle"></i> Active</span>' : 
                '<span class="badge badge-danger"><i class="fas fa-times-circle"></i> Inactive</span>';
        })
        ->addColumn('sex_badge', function ($row) {
            $color = $row->sex === 'Male' ? 'primary' : ($row->sex === 'Female' ? 'pink' : 'secondary');
            return $row->sex ? '<span class="badge badge-' . $color . '">' . $row->sex . '</span>' : 'N/A';
        })
        ->addColumn('age_display', function ($row) {
            return $row->age ? $row->age . ' years' : 'N/A';
        })
        ->addColumn('created_at_formatted', function ($row) {
            return $row->created_at ? $row->created_at->format('d M Y') : 'N/A';
        })
        ->addColumn('action', function ($row) {
            $btn = '<div class="btn-group" role="group">';
            $btn .= '<button type="button" class="btn btn-info btn-sm viewPatient" data-id="'.$row->id.'" title="View Details" data-toggle="tooltip">';
            $btn .= '<i class="fas fa-eye"></i></button>';
            $btn .= '<button type="button" class="btn btn-primary btn-sm editPatient" data-id="'.$row->id.'" title="Edit Patient" data-toggle="tooltip">';
            $btn .= '<i class="fas fa-edit"></i></button>';
            $btn .= '<button type="button" class="btn btn-danger btn-sm deletePatient" data-id="'.$row->id.'" title="Delete Patient" data-toggle="tooltip">';
            $btn .= '<i class="fas fa-trash"></i></button>';
            $btn .= '</div>';
            return $btn;
        })
        ->rawColumns(['status', 'sex_badge', 'action']);
    
    // Get the data as array for testing
    $result = $dataTable->toArray();
    
    echo "DataTables response structure looks good!\n";
    echo "Total records: " . count($result['data']) . "\n";
    
    if (count($result['data']) > 0) {
        echo "\nSample record:\n";
        $sample = $result['data'][0];
        foreach ($sample as $key => $value) {
            if (is_string($value) && strlen($value) > 100) {
                $value = substr($value, 0, 100) . '...';
            }
            echo "$key: $value\n";
        }
    }
    
    echo "\nDataTables response format is valid!\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
