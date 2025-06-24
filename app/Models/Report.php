<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Report extends Model
{
    protected $fillable = [
        'report_number',
        'patient_id',
        'doctor_id',
        'report_date',
        'sample_collection_date',
        'report_status',
        'technician_name',
        'pathologist_name',
        'comments',
        'total_amount',
        'discount',
        'final_amount',
        'payment_status'
    ];

    protected $casts = [
        'report_date' => 'datetime',
        'sample_collection_date' => 'datetime',
        'total_amount' => 'decimal:2',
        'discount' => 'decimal:2',
        'final_amount' => 'decimal:2'
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function reportTests(): HasMany
    {
        return $this->hasMany(ReportTest::class);
    }

    public function tests(): BelongsToMany
    {
        return $this->belongsToMany(Test::class, 'report_tests')
                    ->withPivot(['result_value', 'reference_range', 'status', 'unit'])
                    ->withTimestamps();
    }

    // Generate unique report number
    public static function generateReportNumber()
    {
        $prefix = 'RPT';
        $date = now()->format('Ymd');
        $lastReport = self::whereDate('created_at', now())->count();
        $sequence = str_pad($lastReport + 1, 4, '0', STR_PAD_LEFT);
        
        return $prefix . $date . $sequence;
    }

    // Get status color for UI
    public function getStatusColorAttribute()
    {
        return match($this->report_status) {
            'pending' => 'warning',
            'in_progress' => 'info',
            'completed' => 'success',
            'delivered' => 'primary',
            default => 'secondary'
        };
    }

    // Get payment status color
    public function getPaymentStatusColorAttribute()
    {
        return match($this->payment_status) {
            'paid' => 'success',
            'partial' => 'warning',
            'pending' => 'danger',
            default => 'secondary'
        };
    }
}
