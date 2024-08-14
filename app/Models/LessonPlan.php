<?php

namespace App\Models;

use App\Models\YearSemester;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LessonPlan extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'unit',
        'department',
        'topic',
        'semester',
        'completion_days',
        'learning_objective',
        'learning_tool',
        'methods',
        'learning_outcome',
        'evaluation_method',
        'level_id',
        'program_id',
        'year_semester_id',
        // 'section_id',
        'teacher_id',
        'subject_id',
    ];

    protected $appends = ['files'];

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
        return $this->belongsTo(Section::class, 'section_id', 'id');
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }
    public function teacher()
    {
        return $this->belongsTo(StaffDirectory::class, 'teacher_id', 'id');
    }

    public function getFilesAttribute()
    {
        return $this->hasMedia() ? $this->getMedia() : [];
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
