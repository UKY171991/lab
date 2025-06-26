<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doctors = [
            [
                'doctor_name' => 'Dr R K Patel Ji',
                'hospital_name' => '',
                'contact_no' => '',
                'address' => '',
                'percent' => 0,
                'specialization' => 'General Medicine',
                'qualification' => 'MBBS, MD',
                'email' => 'rkpatel@hospital.com',
                'status' => true
            ],
            [
                'doctor_name' => 'Dr N S Niranjan Ji',
                'hospital_name' => '',
                'contact_no' => '00',
                'address' => '',
                'percent' => 40,
                'specialization' => 'Cardiology',
                'qualification' => 'MBBS, MD, DM',
                'email' => 'nsniranjan@hospital.com',
                'status' => true
            ],
            [
                'doctor_name' => 'R.N .SINGH JI',
                'hospital_name' => '',
                'contact_no' => '000',
                'address' => '',
                'percent' => 50,
                'specialization' => 'Orthopedics',
                'qualification' => 'MBBS, MS',
                'email' => 'rnsingh@hospital.com',
                'status' => true
            ],
            [
                'doctor_name' => 'Dr Self',
                'hospital_name' => '',
                'contact_no' => '000',
                'address' => '',
                'percent' => 50,
                'specialization' => 'General Practice',
                'qualification' => 'MBBS',
                'email' => 'self@hospital.com',
                'status' => true
            ],
            [
                'doctor_name' => 'GOPAL SINGH JI',
                'hospital_name' => '',
                'contact_no' => '00',
                'address' => '',
                'percent' => 50,
                'specialization' => 'Surgery',
                'qualification' => 'MBBS, MS',
                'email' => 'gopalsingh@hospital.com',
                'status' => true
            ],
            [
                'doctor_name' => 'SAGAR JI',
                'hospital_name' => '',
                'contact_no' => '',
                'address' => '',
                'percent' => 50,
                'specialization' => 'Pediatrics',
                'qualification' => 'MBBS, MD',
                'email' => 'sagar@hospital.com',
                'status' => true
            ],
            [
                'doctor_name' => 'MAA VISHNAVI HOSPITAL',
                'hospital_name' => 'MAA VISHNAVI HOSPITAL',
                'contact_no' => '',
                'address' => '',
                'percent' => 0,
                'specialization' => 'Multi-Specialty',
                'qualification' => '',
                'email' => 'info@maavishnavi.com',
                'status' => true
            ],
            [
                'doctor_name' => 'PRABHA HOSPITAL BKP',
                'hospital_name' => 'PRABHA HOSPITAL BKP',
                'contact_no' => '',
                'address' => '',
                'percent' => 0,
                'specialization' => 'General Hospital',
                'qualification' => '',
                'email' => 'info@prabhahospital.com',
                'status' => true
            ]
        ];

        foreach ($doctors as $doctor) {
            \App\Models\Doctor::create($doctor);
        }

        // Create additional 92 doctors using factory (8 already created above = 100 total)
        \App\Models\Doctor::factory(92)->create();
    }
}
