<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeType extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'fee_code', 'account_category_id', 'submission_type', 'description'];


    public function account_category(){
        return $this->belongsTo(AccountCategory::class, 'account_category_id', 'id');
    }

    public function feeDiscounts(){
        return $this->hasMany(FeeDiscount::class);
    }

    public function feeMasters(){
        return $this->hasMany(FeeMaster::class);
    }
}
