<?php

namespace Database\Seeders;

use App\Models\ReportTest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReportTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 3-5 report tests for each report (assuming we have 100 reports)
        // This will create around 300-500 report tests
        ReportTest::factory(400)->create();
    }
}
