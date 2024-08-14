<?php

namespace App\Models;

use App\Casts\SystemDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeMaster extends Model
{
    use HasFactory;
    protected $fillable = ['year_semester_id', 'fee_title_id', 'fee_type_id', 'due_date', 'amount', 'fine_type', 'percentage', 'fine_amount'];

    protected $casts = [
        'due_date' => SystemDate::class,
    ];

    public function fee_title()
    {
        return $this->belongsTo(FeeTitle::class, 'fee_title_id', 'id');
    }

    public function fee_type()
    {
        return $this->belongsTo(FeeType::class, 'fee_type_id', 'id');
    }

    public function yearSemester()
    {
        return $this->belongsTo(YearSemester::class);
    }

    public function assignFees()
    {
        return $this->hasMany(AssignFee::class);
    }

    public function scopeFilterBy($query, $filters)
    {
        $query->when($filters['year_semester_id'] ?? null, function ($query, $yearSemesterId) {
            $query->where('year_semester_id', $yearSemesterId);
        });
    }
}
