<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'package_name',
        'amount',
        'description',
        'tests',
        'status'
    ];

    protected $casts = [
        'tests' => 'array',
        'status' => 'boolean',
        'amount' => 'decimal:2'
    ];

    // Relationship to get test details
    public function getTestsDetailsAttribute()
    {
        if (!$this->tests) {
            return collect();
        }
        
        return \App\Models\Test::whereIn('id', $this->tests)->get();
    }

    // Get total calculated amount from tests
    public function getCalculatedAmountAttribute()
    {
        if (!$this->tests) {
            return 0;
        }
        
        return \App\Models\Test::whereIn('id', $this->tests)->sum('amount') ?? 0;
    }
}
