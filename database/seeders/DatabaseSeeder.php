<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed roles first (required for users)
        $this->call(RoleSeeder::class);

        // Create 100 users with proper role assignments
        User::factory(100)->create();

        // Seed all other tables with 100 records each
        $this->call([
            TestCategorySeeder::class,  // Categories first (tests depend on them)
            TestSeeder::class,          // Tests second
            DoctorSeeder::class,        // Doctors 
            PatientSeeder::class,       // Patients
            PackageSeeder::class,       // Packages
            AssociateSeeder::class,     // Associates
            ReportSeeder::class,        // Reports (depends on patients and doctors)
            ReportTestSeeder::class,    // Report tests (depends on reports and tests)
        ]);
    }
}
