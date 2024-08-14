<?php

namespace App\Models;

use App\Casts\SystemDate;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamSubject extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'subject_id',
        'date',
        'time',
        'duration',
        'room_number',

        'theory_full_marks',
        'practical_full_marks',
        'theory_pass_marks',
        'practical_pass_marks',
        'include_theory',
        'include_practical'
    ];

    protected $casts = [
        'date' => SystemDate::class,
    ];

    public function getTimeAttribute()
    {
        return Carbon::createFromFormat('H:i:s', $this->attributes['time']);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
