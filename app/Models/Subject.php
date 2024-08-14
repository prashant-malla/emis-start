<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'name',
        'description',
        'level_id',
        'program_id',
        // 'year_semester_id',
        // 'section_id',
        'credit_hour',
        'type',
        'theory_full_marks',
        'practical_full_marks',
        'theory_pass_marks',
        'practical_pass_marks',
        'is_optional',
        'year_semester_number'
    ];

    protected $casts = [
        'theory_full_marks' => 'float',
        'practical_full_marks' => 'float',
        'theory_pass_marks' => 'float',
        'practical_pass_marks' => 'float',
    ];

    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id', 'id');
    }
    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }
    public function yearsemester()
    {
        return $this->belongsTo(YearSemester::class, 'year_semester_id', 'id');
    }
    public function section()
    {
        // return $this->belongsTo(Section::class, 'section_id', 'id');
    }
    public function homework()
    {
        return $this->hasMany(Homework::class);
    }

    public function teacher_assigns()
    {
        return $this->hasMany(TeacherAssign::class, 'teacher_id', 'id');
    }
    public function teacher_assigned_subjects()
    {
        return $this->hasMany(TeacherAssign::class, 'subject_id', 'id');
    }
    public function sections()
    {
        return $this->belongsToMany(Section::class);
    }

    public function examSubjects()
    {
        return $this->hasMany(ExamSubject::class);
    }

    public function scopeOptional($query)
    {
        return $query->where('is_optional', 1);
    }

    public function scopeFilterBy($query, $filters)
    {
        // $query->when($filters['batch_id'] ?? null, function ($query, $batchId) {
        //     $yearSemesterIds = YearSemester::where('batch_id', $batchId)->pluck('id');
        //     $query->whereIn('year_semester_id', $yearSemesterIds);
        // })->when($filters['level_id'] ?? null, function ($query, $levelId) {

        $query->when($filters['level_id'] ?? null, function ($query, $levelId) {
            $query->where('level_id', $levelId);
        })->when($filters['program_id'] ?? null, function ($query, $programId) {
            $query->where('program_id', $programId);
        })->when($filters['year_semester_number'] ?? null, function ($query, $yearSemesterNumber) {
            $query->where('year_semester_number', $yearSemesterNumber);
        });
    }
}
