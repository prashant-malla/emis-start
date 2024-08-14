<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LedgerAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_name',
        'account_category_id',
        'balance'
    ];

    /**
     * Get the accountCategory that owns the LedgerAccount
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function accountCategory(): BelongsTo
    {
        return $this->belongsTo(AccountCategory::class);
    }

    /**
     * Get the generalLedgers that belongs to LedgerAccount
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function generalLedgers(): HasMany
    {
        return $this->hasMany(GeneralLedger::class);
    }
}
