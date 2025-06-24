<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestCategory extends Model
{
    protected $fillable = [
        'category_name',
        'description',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    // Relationship to get tests count
    public function tests()
    {
        return $this->hasMany(Test::class, 'category_id');
    }

    // Get tests count attribute
    public function getTestsCountAttribute()
    {
        return $this->tests()->count();
    }
}
