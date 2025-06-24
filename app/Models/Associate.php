<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Associate extends Model
{
    protected $fillable = [
        'name',
        'hospital_name',
        'contact_no',
        'address',
        'percent',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean',
        'percent' => 'decimal:2'
    ];
}
