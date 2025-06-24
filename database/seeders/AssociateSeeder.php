<?php

namespace Database\Seeders;

use App\Models\Associate;
use Illuminate\Database\Seeder;

class AssociateSeeder extends Seeder
{
    public function run(): void
    {
        $associates = [
            [
                'name' => 'Dr. Rajesh Kumar',
                'hospital_name' => 'City General Hospital',
                'contact_no' => '+91 9876543210',
                'address' => '123 Medical Center, Downtown, Mumbai - 400001',
                'percent' => 15.00,
                'status' => true,
            ],
            [
                'name' => 'Dr. Priya Sharma',
                'hospital_name' => 'Metro Health Clinic',
                'contact_no' => '+91 9876543211',
                'address' => '456 Health Street, Bandra, Mumbai - 400050',
                'percent' => 20.00,
                'status' => true,
            ],
            [
                'name' => 'Dr. Amit Patel',
                'hospital_name' => 'Sunrise Medical Center',
                'contact_no' => '+91 9876543212',
                'address' => '789 Care Avenue, Andheri, Mumbai - 400058',
                'percent' => 12.50,
                'status' => true,
            ],
            [
                'name' => 'Dr. Sneha Joshi',
                'hospital_name' => 'Prime Healthcare',
                'contact_no' => '+91 9876543213',
                'address' => '321 Wellness Road, Powai, Mumbai - 400076',
                'percent' => 18.00,
                'status' => false,
            ],
            [
                'name' => 'Dr. Vikram Singh',
                'hospital_name' => 'Elite Diagnostics',
                'contact_no' => '+91 9876543214',
                'address' => '654 Lab Complex, Malad, Mumbai - 400064',
                'percent' => 25.00,
                'status' => true,
            ],
            [
                'name' => 'Dr. Kavya Reddy',
                'hospital_name' => 'Advanced Care Center',
                'contact_no' => '+91 9876543215',
                'address' => '987 Medical Plaza, Thane, Mumbai - 400601',
                'percent' => 22.50,
                'status' => true,
            ],
        ];

        foreach ($associates as $associate) {
            Associate::create($associate);
        }
    }
}
