<?php

namespace App\Models;

use App\Casts\SystemDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AcademicCalendar extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'date',
    ];

    protected $casts = [
        'date' => SystemDate::class,
    ];
}
