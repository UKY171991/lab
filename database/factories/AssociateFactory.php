<?php

namespace Database\Factories;

use App\Models\Associate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Associate>
 */
class AssociateFactory extends Factory
{
    protected $model = Associate::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $hospitalTypes = ['Hospital', 'Clinic', 'Medical Center', 'Healthcare Center', 'Diagnostic Center'];

        return [
            'name' => $this->faker->name(),
            'hospital_name' => $this->faker->company() . ' ' . $this->faker->randomElement($hospitalTypes),
            'contact_no' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'percent' => $this->faker->randomFloat(2, 5, 25), // 5-25% commission
            'status' => $this->faker->boolean(90), // 90% chance of being active
        ];
    }
}
