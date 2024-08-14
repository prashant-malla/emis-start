<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    protected $fillable = [
        'master_section_id',
        'group_name',
        'program_id',
        'year_semester_id',
        'level_id',
    ];
    public function class()
    {
        return $this->belongsTo('App\Models\Eclass', 'class_id', 'id');
    }
    public function session()
    {
        return $this->hasMany(SessionClass::class);
    }
    public function students()
    {
        return $this->hasMany(Student::class);
    }
    public function meeting()
    {
        return $this->hasMany(Meeting::class);
    }
    public function program()
    {
        return $this->belongsTo('App\Models\Program', 'program_id', 'id');
    }
    public function level()
    {
        return $this->belongsTo('App\Models\Level', 'level_id', 'id');
    }
    public function yearsemester()
    {
        return $this->belongsTo('App\Models\YearSemester', 'year_semester_id', 'id');
    }
    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }

    public function scopeFilterBy($query, $filters)
    {
        $query->when($filters['academic_year_id'] ?? null, function ($query, $academicYearId) {
            $yearSemesterIds = YearSemester::where('academic_year_id', $academicYearId)->pluck('id');
            $query->whereIn('year_semester_id', $yearSemesterIds);
        })->when($filters['batch_id'] ?? null, function ($query, $batchId) {
            $yearSemesterIds = YearSemester::where('batch_id', $batchId)->pluck('id');
            $query->whereIn('year_semester_id', $yearSemesterIds);
        })->when($filters['level_id'] ?? null, function ($query, $levelId) {
            $query->where('level_id', $levelId);
        })->when($filters['program_id'] ?? null, function ($query, $programId) {
            $query->where('program_id', $programId);
        })->when($filters['year_semester_id'] ?? null, function ($query, $yearSemesterId) {
            $query->where('year_semester_id', $yearSemesterId);
        });
    }
}
