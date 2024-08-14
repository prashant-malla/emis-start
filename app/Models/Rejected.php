<?php

namespace App\Models;

use App\Casts\SystemDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rejected extends Model
{
    use HasFactory;
    protected $table = 'rejecteds';
    protected  $fillable = [
        'from_date',
        'to_date'
    ];

    protected $casts = [
        'from_date' => SystemDate::class,
        'to_date' => SystemDate::class,
    ];
}
