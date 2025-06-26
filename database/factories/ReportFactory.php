<?php

namespace Database\Factories;

use App\Models\Report;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Report>
 */
class ReportFactory extends Factory
{
    protected $model = Report::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $totalAmount = $this->faker->randomFloat(2, 500, 5000);
        $discount = $this->faker->randomFloat(2, 0, $totalAmount * 0.2); // Up to 20% discount
        $finalAmount = $totalAmount - $discount;

        return [
            'report_number' => 'RPT' . $this->faker->unique()->numerify('########'),
            'patient_id' => \App\Models\Patient::inRandomOrder()->first()?->id ?? Patient::factory(),
            'doctor_id' => \App\Models\Doctor::inRandomOrder()->first()?->id ?? Doctor::factory(),
            'report_date' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'sample_collection_date' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'report_status' => $this->faker->randomElement(['pending', 'in_progress', 'completed', 'delivered']),
            'technician_name' => $this->faker->name(),
            'pathologist_name' => 'Dr. ' . $this->faker->name(),
            'comments' => $this->faker->optional()->paragraph(2),
            'total_amount' => $totalAmount,
            'discount' => $discount,
            'final_amount' => $finalAmount,
            'payment_status' => $this->faker->randomElement(['pending', 'partial', 'paid']),
        ];
    }
}
