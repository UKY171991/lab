<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create basic required roles first
        $basicRoles = [
            ['name' => 'admin', 'description' => 'Administrator with full access'],
            ['name' => 'doctor', 'description' => 'Medical doctor'],
            ['name' => 'technician', 'description' => 'Lab technician'],
            ['name' => 'receptionist', 'description' => 'Front desk receptionist'],
            ['name' => 'manager', 'description' => 'Lab manager'],
        ];

        foreach ($basicRoles as $role) {
            Role::firstOrCreate(['name' => $role['name']], $role);
        }
    }
}
