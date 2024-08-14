<?php

namespace App\Models;

use App\Casts\SystemDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Counsel extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'staff_id',
        'user_id',
        'counselt_name',
        'counselling_type',
        'level_id',
        'program_id',
        'year_semester_id',
        'section_id',
        'counselte_name',
        'ethnicity',
        'counsel_date',
        'card_no',
        'issue',
        'recommendation',
    ];

    protected $casts = [
        'counsel_date' => SystemDate::class,
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
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }
    // public function setCategoryAttribute($value)
    // {
    //     $this->attributes['complaint'] = json_encode($value);
    // }

    // public function getCategoryAttribute($value)
    // {
    //     return $this->attributes['complaint'] = json_decode($value);
    // }



    public function scopeFilterBy($query, $filters)
    {
        $query->when(
            $filters['academic_year_id'] ?? null,
            function ($query, $academicYearId) {
                $yearSemesterIds = YearSemester::where('academic_year_id', $academicYearId)->pluck('id');
                $query->whereIn('year_semester_id', $yearSemesterIds);
            }
        )->when(
            $filters['batch_id'] ?? null,
            function ($query, $batchId) {
                $yearSemesterIds = YearSemester::where('batch_id', $batchId)->pluck('id');
                $query->whereIn('year_semester_id', $yearSemesterIds);
            }
        )->when(
            $filters['level_id'] ?? null,
            function ($query, $levelId) {
                $query->where('level_id', $levelId);
            }
        )->when(
            $filters['program_id'] ?? null,
            function ($query, $programId) {
                $query->where('program_id', $programId);
            }
        )->when(
            $filters['year_semester_id'] ?? null,
            function ($query, $yearSemesterId) {
                $query->where('year_semester_id', $yearSemesterId);
            }
        );
    }
}
