<?php

namespace App\Models;

use App\Casts\SystemDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Homework extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'level_id',
        'program_id',
        'year_semester_id',
        'section_id',
        'subject_id',
        'assign',
        'submission',
        'submission_time',
        'description',
        'teacher_id',
    ];

    protected $appends = ['files'];

    protected $casts = [
        'assign' => SystemDate::class,
        'submission' => SystemDate::class,
    ];

    public function level()
    {
        return $this->belongsTo('App\Models\Level', 'level_id', 'id');
    }
    public function program()
    {
        return $this->belongsTo('App\Models\Program', 'program_id', 'id');
    }
    public function yearsemester()
    {
        return $this->belongsTo('App\Models\YearSemester', 'year_semester_id', 'id');
    }
    public function section()
    {
        return $this->belongsTo('App\Models\Section', 'section_id', 'id');
    }
    public function subject()
    {
        return $this->belongsTo('App\Models\Subject', 'subject_id', 'id');
    }
    public function teacher()
    {
        return $this->belongsTo('App\Models\StaffDirectory', 'teacher_id', 'id');
    }
    public function homeworksubmission()
    {
        return $this->hasMany(HomeworkSubmission::class);
    }
    // public function getTimeAttribute()
    // {
    //     return Carbon::createFromFormat('H:i:s', $this->attributes['submission_time']);
    // }
    public function getFilesAttribute()
    {
        return $this->hasMedia() ? $this->getMedia() : [];
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
}
