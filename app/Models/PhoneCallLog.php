<?php

namespace App\Models;

use App\Casts\SystemDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneCallLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'phone',
        'date',
        'follow_up_date',
        'description',
        'call_duration',
        'note',
        'call_type'
    ];

    protected $casts = [
        'date' => SystemDate::class,
        'follow_up_date' => SystemDate::class,
    ];
}
