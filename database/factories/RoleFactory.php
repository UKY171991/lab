<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    protected $model = Role::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $roles = ['admin', 'doctor', 'technician', 'receptionist', 'manager'];
        
        return [
            'name' => $this->faker->unique()->randomElement($roles),
            'description' => $this->faker->sentence(6),
        ];
    }
}
