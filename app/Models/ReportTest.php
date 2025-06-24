<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportTest extends Model
{
    protected $fillable = [
        'report_id',
        'test_id',
        'result_value',
        'reference_range',
        'status',
        'unit',
        'remarks'
    ];

    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }

    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }

    // Get status color for UI
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'normal' => 'success',
            'high' => 'danger',
            'low' => 'warning',
            'critical' => 'dark',
            default => 'secondary'
        };
    }

    // Get status icon
    public function getStatusIconAttribute()
    {
        return match($this->status) {
            'normal' => 'fas fa-check-circle',
            'high' => 'fas fa-arrow-up',
            'low' => 'fas fa-arrow-down',
            'critical' => 'fas fa-exclamation-triangle',
            default => 'fas fa-minus'
        };
    }
}
