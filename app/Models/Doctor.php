<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'doctor_name',
        'hospital_name',
        'contact_no',
        'address',
        'percent',
        'specialization',
        'qualification',
        'email',
        'emergency_contact',
        'license_number',
        'license_expiry',
        'notes',
        'status'
    ];

    protected $casts = [
        'license_expiry' => 'date',
        'status' => 'boolean',
        'percent' => 'decimal:2'
    ];
}
