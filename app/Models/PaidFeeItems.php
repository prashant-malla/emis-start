<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaidFeeItems extends Model
{
    use HasFactory;

    protected $fillable = [
        'paid_fee_id',
        'assign_fee_id',
        'amount_paid',
    ];
}
