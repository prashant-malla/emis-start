<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralLedger extends Model
{
    use HasFactory;

    protected $fillable = [
        'voucher_id',
        'ledger_account_id',
        'debit_amount',
        'credit_amount',
        'remark'
    ];

    public function ledgerAccount()
    {
        return $this->belongsTo(LedgerAccount::class);
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }

    public function accountCategory()
    {
        return $this->belongsToMany(AccountCategory::class)->using(LedgerAccount::class);
    }
}
