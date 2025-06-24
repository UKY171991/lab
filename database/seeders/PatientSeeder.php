<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patients = [
            [
                'client_name' => 'Rajesh Kumar',
                'mobile_number' => '9876543210',
                'father_husband_name' => 'Ram Kumar',
                'address' => '123 Main Street, Delhi',
                'sex' => 'Male',
                'age' => 35,
                'email' => 'rajesh.kumar@email.com',
                'date_of_birth' => '1990-05-15',
                'blood_group' => 'B+',
                'occupation' => 'Software Engineer',
                'emergency_contact' => '9876543211',
                'medical_history' => 'Hypertension',
                'allergies' => 'None',
                'status' => true
            ],
            [
                'client_name' => 'Priya Sharma',
                'mobile_number' => '9876543212',
                'father_husband_name' => 'Suresh Sharma',
                'address' => '456 Park Avenue, Mumbai',
                'sex' => 'Female',
                'age' => 28,
                'email' => 'priya.sharma@email.com',
                'date_of_birth' => '1997-08-22',
                'blood_group' => 'A+',
                'occupation' => 'Teacher',
                'emergency_contact' => '9876543213',
                'medical_history' => 'Diabetes',
                'allergies' => 'Penicillin',
                'status' => true
            ],
            [
                'client_name' => 'Amit Patel',
                'mobile_number' => '9876543214',
                'father_husband_name' => 'Kiran Patel',
                'address' => '789 Green Valley, Ahmedabad',
                'sex' => 'Male',
                'age' => 42,
                'email' => 'amit.patel@email.com',
                'date_of_birth' => '1983-12-10',
                'blood_group' => 'O+',
                'occupation' => 'Business Owner',
                'emergency_contact' => '9876543215',
                'medical_history' => 'None',
                'allergies' => 'Dust',
                'status' => true
            ],
            [
                'client_name' => 'Sunita Singh',
                'mobile_number' => '9876543216',
                'father_husband_name' => 'Ramesh Singh',
                'address' => '321 River Side, Kolkata',
                'sex' => 'Female',
                'age' => 38,
                'email' => 'sunita.singh@email.com',
                'date_of_birth' => '1987-03-18',
                'blood_group' => 'AB+',
                'occupation' => 'Doctor',
                'emergency_contact' => '9876543217',
                'medical_history' => 'Migraine',
                'allergies' => 'Seafood',
                'status' => true
            ],
            [
                'client_name' => 'Vikash Gupta',
                'mobile_number' => '9876543218',
                'father_husband_name' => 'Mohan Gupta',
                'address' => '654 Hill View, Pune',
                'sex' => 'Male',
                'age' => 25,
                'email' => 'vikash.gupta@email.com',
                'date_of_birth' => '2000-11-05',
                'blood_group' => 'O-',
                'occupation' => 'Student',
                'emergency_contact' => '9876543219',
                'medical_history' => 'Asthma',
                'allergies' => 'Pollen',
                'status' => true
            ]
        ];

        foreach ($patients as $patient) {
            \App\Models\Patient::create($patient);
        }
    }
}
