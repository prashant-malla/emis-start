<?php

namespace App\Models;

use App\Casts\SystemDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignFee extends Model
{
    use HasFactory;
    protected $fillable = ['fee_master_id', 'program_id', 'year_semester_id', 'section_id', 'student_id', 'month_name', 'due_date', 'previous_session_fee'];

    protected $casts = [
        'due_date' => SystemDate::class,
    ];

    public function fee_master()
    {
        return $this->belongsTo(FeeMaster::class, 'fee_master_id', 'id');
    }
    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }
    public function year_semester()
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
        })->when($filters['month_name'] ?? null, function ($query, $monthName) {
            $query->where('month_name', $monthName);
        });
    }
}
