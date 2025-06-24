<?php

namespace Database\Seeders;

use App\Models\Package;
use App\Models\Test;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some test IDs to use in packages
        $testIds = Test::pluck('id')->take(5)->toArray();
        
        if (empty($testIds)) {
            return; // No tests available
        }

        $packages = [
            [
                'package_name' => 'Basic Health Checkup',
                'amount' => 1200.00,
                'description' => 'Basic health screening package including essential tests',
                'tests' => array_slice($testIds, 0, 3),
                'status' => true,
            ],
            [
                'package_name' => 'Comprehensive Health Package',
                'amount' => 2500.00,
                'description' => 'Complete health checkup with advanced tests',
                'tests' => $testIds,
                'status' => true,
            ],
            [
                'package_name' => 'Diabetes Panel',
                'amount' => 800.00,
                'description' => 'Specialized package for diabetes monitoring',
                'tests' => array_slice($testIds, 1, 2),
                'status' => true,
            ],
            [
                'package_name' => 'Cardiac Care Package',
                'amount' => 1800.00,
                'description' => 'Heart health assessment package',
                'tests' => array_slice($testIds, 2, 3),
                'status' => false,
            ],
        ];

        foreach ($packages as $packageData) {
            Package::create($packageData);
        }
    }
}
