<?php

namespace App\Models;

use App\Casts\SystemDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentPromotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'from_year_semester_id',
        'to_year_semester_id',
        'promotion_date',
    ];

    protected $casts = [
        'promotion_date' => SystemDate::class
    ];
}
