<?php

namespace App\Models;

use App\Casts\SystemDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CollectFee extends Model
{
    use HasFactory;
    protected $fillable = ['paid_fee_id', 'student_id', 'fee_type_id', 'assign_fee_id', 'due_date', 'fee_amount', 'discount', 'fine', 'previous_session_fee', 'total_balance', 'month_name', 'status'];

    protected $casts = [
        'due_date' => SystemDate::class,
    ];

    public function fee_type()
    {
        return $this->belongsTo(FeeType::class, 'fee_type_id', 'id');
    }
    public function paid_fee()
    {
        return $this->belongsTo(PaidFee::class);
    }
    public function feeType(): BelongsTo
    {
        return $this->belongsTo(FeeType::class);
    }

    public function assignFee(): BelongsTo
    {
        return $this->belongsTo(AssignFee::class);
    }
}
