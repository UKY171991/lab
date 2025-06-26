<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    protected $model = Patient::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_name' => $this->faker->name(),
            'mobile_number' => $this->faker->phoneNumber(),
            'father_husband_name' => $this->faker->name('male'),
            'address' => $this->faker->address(),
            'sex' => $this->faker->randomElement(['male', 'female', 'other']),
            'age' => $this->faker->numberBetween(1, 100),
            'uhid' => 'UHID' . $this->faker->unique()->numerify('######'),
            'email' => $this->faker->optional()->safeEmail(),
            'date_of_birth' => $this->faker->dateTimeBetween('-100 years', '-1 year'),
            'blood_group' => $this->faker->randomElement(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']),
            'occupation' => $this->faker->jobTitle(),
            'emergency_contact' => $this->faker->phoneNumber(),
            'medical_history' => $this->faker->optional()->paragraph(3),
            'allergies' => $this->faker->optional()->words(3, true),
            'notes' => $this->faker->optional()->paragraph(2),
            'status' => $this->faker->boolean(95), // 95% chance of being active
        ];
    }
}
