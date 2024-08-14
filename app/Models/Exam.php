<?php

namespace App\Models;

use App\Casts\SystemDate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exam extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'exam_type_id',
        'level_id',
        'program_id',
        'year_semester_id',
        'result_date',
        'status',
        'deleted_at',
        'attempt'
    ];

    protected $appends = [
        'start_date'
    ];

    protected $casts = [
        'result_date' => SystemDate::class,
        'created_at' => SystemDate::class
    ];

    // public function session()
    // {
    //     return $this->belongsTo(Session::class);
    // }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function yearSemester()
    {
        return $this->belongsTo(YearSemester::class);
    }

    public function examSubjects()
    {
        return $this->hasMany(ExamSubject::class);
    }

    public function examType()
    {
        return $this->belongsTo(ExamType::class);
    }

    public function scopeActive(Builder $query)
    {
        return $query->where('status', 1);
    }

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

    public function getStartDateAttribute()
    {
        return count($this->examSubjects) > 0 ? $this->examSubjects()->oldest('date')->first()->date : null;
    }
}
