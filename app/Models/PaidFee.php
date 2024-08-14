<?php

namespace App\Models;

use App\Casts\SystemDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaidFee extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'bill_number', 'date', 'due_amount', 'old_balance', 'fine_amount', 'discount_amount', 'paid_amount', 'payment_mode', 'note'];

    protected $casts = [
        'date' => SystemDate::class,
    ];

    public function collect_fees()
    {
        return $this->hasMany(CollectFee::class);
    }

    public function collectedFees()
    {
        return $this->hasMany(CollectFee::class);
    }

    public function paidFeeItems()
    {
        return $this->hasMany(PaidFeeItems::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function scopeFilterBy($query, $filters)
    {
        $query->when($filters['student_id'] ?? null, function ($query, $studentId) {
            $query->where('student_id', $studentId);
        })->when($filters['from_date'] ?? null, function ($query, $fromDate) use ($filters) {
            $query->when($filters['to_date'] ?? null, function ($query, $toDate) use ($fromDate) {
                $query->whereBetween('date', [convertToEngDate($fromDate), convertToEngDate($toDate)]);
            });
        });
    }
}
