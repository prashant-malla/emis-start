<?php

namespace App\Models;

use App\Casts\SystemDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Notice extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'notice_date',
        'notice_to',
        'message',
    ];

    protected $casts = [
        'notice_date' => SystemDate::class,
        'created_at' => SystemDate::class
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
    
    /**
     * The academicYears that belong to the Notice
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function academicYears(): BelongsToMany
    {
        return $this->belongsToMany(AcademicYear::class, 'academic_year_notice');
    }

    /**
     * The batches that belong to the Notice
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function batches(): BelongsToMany
    {
        return $this->belongsToMany(Batch::class, 'batch_notice');
    }


    public function levels()
    {
        return $this->belongsToMany(Level::class, 'notice_level');
    }
    public function programs()
    {
        return $this->belongsToMany(Program::class, 'notice_program');
    }
    public function yearSemesters()
    {
        return $this->belongsToMany(YearSemester::class, 'notice_year_semester');
    }
    public function sections()
    {
        return $this->belongsToMany(Section::class);
    }

    public function scopeFilterBy($query, $filters)
    {
        $query->when(isset($filters['academic_year_id']), function ($query) use ($filters) {
            $query->whereHas('yearsemesters', function ($subquery) use ($filters) {
                $subquery->where('academic_year_id', $filters['academic_year_id']);
            });
        })->when(isset($filters['batch_id']), function ($query) use ($filters) {
            $query->whereHas('yearsemesters', function ($subquery) use ($filters) {
                $subquery->where('batch_id', $filters['batch_id']);
            });
        });
    }
}
