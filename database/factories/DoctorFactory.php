<?php

namespace Database\Factories;

use App\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    protected $model = Doctor::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $specializations = [
            'Pathology', 'Hematology', 'Biochemistry', 'Microbiology', 
            'Clinical Chemistry', 'Immunology', 'Molecular Biology',
            'Cytology', 'Histopathology', 'Medical Genetics',
            'General Medicine', 'Cardiology', 'Orthopedics', 'Surgery',
            'Pediatrics', 'Gynecology', 'Dermatology', 'Neurology'
        ];

        return [
            'doctor_name' => 'Dr. ' . $this->faker->name(),
            'hospital_name' => $this->faker->optional()->company() . ' Hospital',
            'contact_no' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'percent' => $this->faker->randomFloat(2, 0, 50),
            'specialization' => $this->faker->randomElement($specializations),
            'qualification' => $this->faker->randomElement(['MBBS', 'MBBS, MD', 'MBBS, MS', 'MBBS, MD, DM', 'MBBS, MS, MCh']),
            'email' => $this->faker->unique()->safeEmail(),
            'emergency_contact' => $this->faker->phoneNumber(),
            'license_number' => 'LIC' . $this->faker->unique()->numerify('######'),
            'license_expiry' => $this->faker->dateTimeBetween('now', '+5 years'),
            'notes' => $this->faker->optional()->paragraph(2),
            'status' => $this->faker->boolean(95), // 95% chance of being active
        ];
    }
}
