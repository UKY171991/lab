<?php

namespace Database\Factories;

use App\Models\TestCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TestCategory>
 */
class TestCategoryFactory extends Factory
{
    protected $model = TestCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            'Hematology', 'Biochemistry', 'Microbiology', 'Immunology',
            'Clinical Chemistry', 'Endocrinology', 'Cardiology', 'Nephrology',
            'Hepatology', 'Oncology', 'Toxicology', 'Molecular Biology',
            'Cytology', 'Histopathology', 'Genetics', 'Virology',
            'Parasitology', 'Serology', 'Coagulation', 'Lipid Profile',
            'Thyroid Function', 'Liver Function', 'Kidney Function', 'Cardiac Markers'
        ];

        return [
            'category_name' => $this->faker->unique()->randomElement($categories),
            'description' => $this->faker->sentence(8),
            'status' => $this->faker->boolean(90), // 90% chance of being active
        ];
    }
}
