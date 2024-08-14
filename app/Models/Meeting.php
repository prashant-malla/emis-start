<?php

namespace App\Models;

use App\Casts\SystemDate;
use App\Models\YearSemester;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Meeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'level_id',
        'program_id',
        'year_semester_id',
        'section_id',
        'teacher_id',
        'meeting_date',
        'meeting_time',
        'note',
        'link',
        'document'
    ];

    protected $casts = [
        'meeting_date' => SystemDate::class,
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
    /**
     * Set the user's first name.
     *
     * @param  string  $value
     * @return void
     */
    public function setFilenamesAttribute($value)
    {
        $this->attributes['document'] = json_encode($value);
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
