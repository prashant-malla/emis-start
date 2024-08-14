<?php

namespace App\Models;

use App\Casts\SystemDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grievance extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'staff_id',
        'user_id',
        'status',
        'complaint',
        'grievance_date',
        'location',
        'tormentor_name',
        'grievant_mobile',
        'inform_to',
    ];

    protected $casts = [
        'grievance_date' => SystemDate::class,
        'complaint' => 'array'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function staff()
    {
        return $this->belongsTo(StaffDirectory::class, 'staff_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
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
        );
    }

}
