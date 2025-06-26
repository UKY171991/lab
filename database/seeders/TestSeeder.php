<?php

namespace Database\Seeders;

use App\Models\Test;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tests = [
            [
                'test_name' => 'Hemoglobin',
                'specimen' => 'Blood',
                'result_default' => '',
                'unit' => 'g/dL',
                'reference_range' => '12.0-15.5',
                'min_value' => 12.0,
                'max_value' => 15.5,
                'is_sub_heading' => false,
                'testcode' => 'HB001',
                'individual_method' => 'Colorimetric',
                'status' => true
            ],
            [
                'test_name' => 'Complete Blood Count',
                'specimen' => 'Blood',
                'result_default' => '',
                'unit' => '',
                'reference_range' => '',
                'min_value' => null,
                'max_value' => null,
                'is_sub_heading' => true,
                'testcode' => 'CBC001',
                'individual_method' => '',
                'status' => true
            ],
            [
                'test_name' => 'White Blood Cell Count',
                'specimen' => 'Blood',
                'result_default' => '',
                'unit' => 'cells/μL',
                'reference_range' => '4,000-11,000',
                'min_value' => 4000,
                'max_value' => 11000,
                'is_sub_heading' => false,
                'testcode' => 'WBC001',
                'individual_method' => 'Flow Cytometry',
                'status' => true
            ],
            [
                'test_name' => 'Blood Glucose',
                'specimen' => 'Serum',
                'result_default' => '',
                'unit' => 'mg/dL',
                'reference_range' => '70-100',
                'min_value' => 70,
                'max_value' => 100,
                'is_sub_heading' => false,
                'testcode' => 'GLU001',
                'individual_method' => 'Enzymatic',
                'status' => true
            ],
            [
                'test_name' => 'Urea',
                'specimen' => 'Serum',
                'result_default' => '',
                'unit' => 'mg/dL',
                'reference_range' => '15-40',
                'min_value' => 15,
                'max_value' => 40,
                'is_sub_heading' => false,
                'testcode' => 'UREA001',
                'individual_method' => 'Kinetic UV',
                'status' => true
            ]
        ];

        foreach ($tests as $test) {
            Test::create($test);
        }

        // Create additional tests using factory (to reach 100 total)
        $existingCount = count($tests);
        Test::factory(100 - $existingCount)->create();
    }
}
