<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'client_name',
        'mobile_number',
        'father_husband_name',
        'address',
        'sex',
        'age',
        'uhid',
        'email',
        'date_of_birth',
        'blood_group',
        'occupation',
        'emergency_contact',
        'medical_history',
        'allergies',
        'notes',
        'status'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'status' => 'boolean',
        'age' => 'integer'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($patient) {
            if (empty($patient->uhid)) {
                $patient->uhid = self::generateUHID();
            }
        });
    }

    private static function generateUHID()
    {
        $prefix = 'UHID';
        $year = date('Y');
        $lastPatient = self::whereYear('created_at', $year)
                          ->orderBy('id', 'desc')
                          ->first();
        
        $number = $lastPatient ? (intval(substr($lastPatient->uhid, -6)) + 1) : 1;
        
        return $prefix . $year . str_pad($number, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Get the reports for the patient.
     */
    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    /**
     * Get the full name attribute.
     */
    public function getFullNameAttribute()
    {
        return $this->client_name;
    }

    /**
     * Get the name attribute (alias for client_name).
     */
    public function getNameAttribute()
    {
        return $this->client_name;
    }

    /**
     * Scope to filter active patients.
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Scope to filter patients by gender.
     */
    public function scopeByGender($query, $gender)
    {
        return $query->where('sex', $gender);
    }

    /**
     * Get age in years.
     */
    public function getAgeInYearsAttribute()
    {
        if ($this->date_of_birth) {
            return $this->date_of_birth->age;
        }
        return $this->age;
    }
}
