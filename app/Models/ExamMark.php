<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamMark extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'subject_id',
        'student_id',
        'theory_mark',
        'practical_mark',
    ];

    public function subject(){
       return $this->belongsTo(Subject::class); 
    }

    public function student(){
       return $this->belongsTo(Student::class); 
    }

    public function getTotalMarksAttribute()
    {
        return $this->theory_mark + $this->practical_mark;
    }
}
