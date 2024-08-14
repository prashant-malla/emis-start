<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignDiscount extends Model
{
    use HasFactory;
    protected $fillable = ['fee_discount_id', 'program_id', 'year_semester_id', 'section_id', 'student_id'];

    public function fee_discount()
    {
        return $this->belongsTo(FeeDiscount::class, 'fee_discount_id', 'id');
    }
    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }
    public function yearSemester()
    {
        return $this->belongsTo(YearSemester::class, 'year_semester_id', 'id');
    }
    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id', 'id');
    }
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function scopeFilterBy($query, $filters)
    {
        $query->when($filters['level_id'] ?? null, function ($query, $levelId) {
            $query->where('level_id', $levelId);
        })->when($filters['program_id'] ?? null, function ($query, $programId) {
            $query->where('program_id', $programId);
        })->when($filters['year_semester_id'] ?? null, function ($query, $yearSemesterId) {
            $query->where('year_semester_id', $yearSemesterId);
        })->when($filters['section_id'] ?? null, function ($query, $sectionId) {
            $query->where('section_id', $sectionId);
        });
    }
}
