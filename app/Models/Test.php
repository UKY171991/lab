<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $fillable = [
        'test_name',
        'specimen',
        'result_default',
        'unit',
        'reference_range',
        'min_value',
        'max_value',
        'is_sub_heading',
        'testcode',
        'individual_method',
        'status'
    ];

    protected $casts = [
        'is_sub_heading' => 'boolean',
        'status' => 'boolean'
    ];
}
