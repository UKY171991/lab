<?php

namespace Database\Factories;

use App\Models\Package;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Package>
 */
class PackageFactory extends Factory
{
    protected $model = Package::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $packageNames = [
            'Basic Health Checkup', 'Comprehensive Health Package', 'Diabetes Care Package',
            'Heart Health Package', 'Liver Function Package', 'Kidney Health Package',
            'Thyroid Care Package', 'Women\'s Health Package', 'Men\'s Health Package',
            'Senior Citizen Package', 'Pre-Employment Package', 'Annual Health Checkup',
            'Executive Health Package', 'Pregnancy Care Package', 'Cancer Screening Package',
            'Cardiac Risk Assessment', 'Metabolic Panel', 'Infectious Disease Panel',
            'Allergy Testing Package', 'Hormone Panel', 'Vitamin Deficiency Package',
            'Sports Medicine Package', 'Pre-Surgical Package', 'Post-COVID Package'
        ];

        $amount = $this->faker->randomFloat(2, 1000, 10000);
        
        // Generate random test IDs (assuming some tests exist)
        $testIds = [];
        for ($i = 0; $i < $this->faker->numberBetween(3, 10); $i++) {
            $testIds[] = $this->faker->numberBetween(1, 50);
        }

        return [
            'package_name' => $this->faker->unique()->randomElement($packageNames),
            'amount' => $amount,
            'description' => $this->faker->paragraph(3),
            'tests' => array_unique($testIds), // Remove duplicates
            'status' => $this->faker->boolean(90), // 90% chance of being active
        ];
    }
}
