<?php

namespace Database\Factories;

use App\Models\ReportTest;
use App\Models\Report;
use App\Models\Test;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ReportTest>
 */
class ReportTestFactory extends Factory
{
    protected $model = ReportTest::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $resultValue = $this->faker->randomFloat(2, 10, 500);
        $referenceRange = $this->faker->numerify('##-###');
        
        // Determine status based on result value (simplified logic)
        $status = $this->faker->randomElement(['normal', 'high', 'low', 'critical']);
        
        $units = ['mg/dL', 'g/dL', 'IU/L', 'U/L', 'ng/mL', 'pg/mL', 'µg/dL', 'mIU/L', 'seconds', 'mm/hr', '%'];

        return [
            'report_id' => \App\Models\Report::inRandomOrder()->first()?->id ?? Report::factory(),
            'test_id' => \App\Models\Test::inRandomOrder()->first()?->id ?? Test::factory(),
            'result_value' => (string) $resultValue,
            'reference_range' => $referenceRange,
            'status' => $status,
            'unit' => $this->faker->randomElement($units),
            'remarks' => $this->faker->optional()->sentence(6),
        ];
    }
}
