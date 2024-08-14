<?php

namespace App\Models;

use App\Casts\SystemDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnApprove extends Model
{
    use HasFactory;
    protected $table = 'unapproves';
    protected  $fillable = [
        'from_date',
        'to_date'
    ];

    protected $casts = [
        'from_date' => SystemDate::class,
        'to_date' => SystemDate::class,
    ];
}
