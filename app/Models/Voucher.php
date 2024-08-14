<?php

namespace App\Models;

use App\Casts\SystemDate;
use App\Enum\VoucherTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'date',
        'amount',
        'type',
        'voucher_number',
        'payment_method',
        'cheque_number'
    ];

    protected $casts = [
        'date' => SystemDate::class,
        // 'type' => VoucherTypeEnum::class
    ];

    /**
     * Get all of the generalLedgers for the Voucher
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function generalLedgers(): HasMany
    {
        return $this->hasMany(GeneralLedger::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('approval_status', array_search('Approved', APPROVAL_STATUS));
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['approval_status'] ?? null, function ($query, $approvalStatus) {
            $query->where('approval_status', $approvalStatus);
        })->when($filters['from_date'] ?? null, function ($query, $fromDate) use ($filters) {
            $query->when($filters['to_date'] ?? null, function ($query, $toDate) use ($fromDate) {
                $query->whereBetween('date', [convertToEngDate($fromDate), convertToEngDate($toDate)]);
            });
        })->when($filters['voucher_number_like'] ?? null, function ($query, $type) {
            $query->where('voucher_number', 'like', $type);
        });
    }
}
