<?php

namespace Database\Seeders;

use App\Models\TestCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'category_name' => 'HEMATOLOGY',
                'description' => 'Blood cell analysis and hematological tests',
                'status' => true,
            ],
            [
                'category_name' => 'BIOCHEMISTRY',
                'description' => 'Chemical analysis of blood and body fluids',
                'status' => true,
            ],
            [
                'category_name' => 'SEROLOGY',
                'description' => 'Immunological and serological testing',
                'status' => true,
            ],
            [
                'category_name' => 'ENDOCRINOLOGY',
                'description' => 'Hormone level testing and endocrine function',
                'status' => true,
            ],
            [
                'category_name' => 'SPECIAL',
                'description' => 'Specialized laboratory tests',
                'status' => true,
            ],
            [
                'category_name' => 'URINE',
                'description' => 'Urinalysis and urine-based testing',
                'status' => true,
            ],
            [
                'category_name' => 'STOOL',
                'description' => 'Stool analysis and parasitology',
                'status' => true,
            ],
            [
                'category_name' => 'SEMEN',
                'description' => 'Semen analysis and reproductive health tests',
                'status' => true,
            ],
            [
                'category_name' => 'SPUTUM',
                'description' => 'Sputum analysis and respiratory tests',
                'status' => true,
            ],
            [
                'category_name' => 'C/S',
                'description' => 'Culture and sensitivity testing',
                'status' => true,
            ],
            [
                'category_name' => 'INFECTIOUS SECTION',
                'description' => 'Infectious disease testing and screening',
                'status' => true,
            ],
            [
                'category_name' => 'MICROBIOLOGY',
                'description' => 'Microbiological analysis and bacterial testing',
                'status' => true,
            ],
            [
                'category_name' => 'FLOWCYTOMETRY',
                'description' => 'Flow cytometry analysis and cell sorting',
                'status' => true,
            ],
            [
                'category_name' => 'Xray',
                'description' => 'X-ray imaging and radiological tests',
                'status' => true,
            ],
            [
                'category_name' => 'Ultr',
                'description' => 'Ultrasound imaging and sonography',
                'status' => true,
            ],
            [
                'category_name' => 'Ultrasound',
                'description' => 'Advanced ultrasound imaging services',
                'status' => true,
            ],
        ];

        foreach ($categories as $categoryData) {
            TestCategory::create($categoryData);
        }

        // Create additional categories using factory (to reach 100 total)
        $existingCount = count($categories);
        TestCategory::factory(100 - $existingCount)->create();
    }
}
