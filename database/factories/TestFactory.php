<?php

namespace Database\Factories;

use App\Models\Test;
use App\Models\TestCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Test>
 */
class TestFactory extends Factory
{
    protected $model = Test::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $testNames = [
            'Complete Blood Count', 'Blood Sugar', 'Cholesterol', 'Liver Function Test',
            'Kidney Function Test', 'Thyroid Function Test', 'Lipid Profile', 'HbA1c',
            'Vitamin D', 'Vitamin B12', 'Iron Studies', 'Cardiac Markers',
            'Uric Acid', 'ESR', 'CRP', 'Prothrombin Time', 'APTT',
            'D-Dimer', 'Troponin', 'PSA', 'CEA', 'AFP', 'CA 125', 'CA 19-9',
            'Hepatitis B Surface Antigen', 'Hepatitis C Antibody', 'HIV Test',
            'VDRL', 'Widal Test', 'Malaria Antigen', 'Dengue Serology'
        ];

        $specimens = ['Blood', 'Urine', 'Stool', 'Saliva', 'Tissue', 'Serum', 'Plasma'];
        $units = ['mg/dL', 'g/dL', 'IU/L', 'U/L', 'ng/mL', 'pg/mL', 'µg/dL', 'mIU/L', 'seconds', 'mm/hr', '%'];

        return [
            'test_name' => $this->faker->unique()->randomElement($testNames),
            'specimen' => $this->faker->randomElement($specimens),
            'result_default' => $this->faker->optional()->randomFloat(2, 10, 500),
            'unit' => $this->faker->randomElement($units),
            'reference_range' => $this->faker->numerify('##-###') . ' ' . $this->faker->randomElement($units),
            'min_value' => $this->faker->randomFloat(2, 1, 100),
            'max_value' => $this->faker->randomFloat(2, 100, 1000),
            'is_sub_heading' => $this->faker->boolean(20), // 20% chance of being sub heading
            'testcode' => 'TEST' . $this->faker->unique()->numerify('####'),
            'individual_method' => $this->faker->optional()->sentence(4),
            'status' => $this->faker->boolean(95), // 95% chance of being active
        ];
    }
}
