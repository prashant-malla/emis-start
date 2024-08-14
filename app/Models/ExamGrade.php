<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamGrade extends Model
{
    use HasFactory;
    protected $fillable = ['grade_name','percentage_from', 'percentage_to', 'grade_point', 'exam_type_id', 'remarks'];
}
