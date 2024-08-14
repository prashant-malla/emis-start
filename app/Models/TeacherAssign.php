<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherAssign extends Model
{
    use HasFactory;

    protected $fillable = [
        'level_id',
        'program_id',
        'year_semester_id',
        'section_id',
        'teacher_id',
        'subject_id',
        'time'
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
        return $this->belongsTo(Section::class, 'section_id', 'id');
    }
    public function teacher()
    {
        return $this->belongsTo(StaffDirectory::class, 'teacher_id', 'id');
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }

    public function scopeFilterBy($query, $filters)
    {
        $query->when($filters['academic_year_id'] ?? null, function ($query, $academicYearId) {
            $yearSemesterIds = YearSemester::where('academic_year_id', $academicYearId)->pluck('id');
            $query->whereIn('year_semester_id', $yearSemesterIds);
        })->when($filters['batch_id'] ?? null, function ($query, $batchId) {
            $yearSemesterIds = YearSemester::where('batch_id', $batchId)->pluck('id');
            $query->whereIn('year_semester_id', $yearSemesterIds);
        });
    }
}
