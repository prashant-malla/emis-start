<?php

namespace App\Models;

use App\Casts\SystemDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YearSemester extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_year_id',
        'batch_id',
        'level_id',
        'program_id',
        'type',
        'name',
        'term_number',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'start_date' => SystemDate::class,
        'end_date' => SystemDate::class,
    ];

    public function level()
    {
        return $this->belongsTo('App\Models\Level', 'level_id', 'id');
    }
    public function program()
    {
        return $this->belongsTo('App\Models\Program', 'program_id', 'id');
    }
    public function admission()
    {
        return $this->hasMany(AdmissionInquiry::class);
    }
    public function groups()
    {
        return $this->hasMany(Section::class);
    }
    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function scopeActive($query)
    {
        $query->where('is_active', 1);
    }

    public function scopeFilterBy($query, $filters)
    {
        $query->when($filters['academic_year_id'] ?? null, function ($query, $academicYearId) {
            // $academicYear = AcademicYear::find($academicYearId);
            // $query->where(function ($query) use ($academicYear) {
            //     $query
            //         ->whereNull('start_date')
            //         ->orWhere('start_date', '<=', convertToEngDate($academicYear->end_date));
            // })->where(function ($query) use ($academicYear) {
            //     $query
            //         ->whereNull('end_date')
            //         ->orWhere('end_date', '>=', convertToEngDate($academicYear->start_date));
            // });
            $query->where('academic_year_id', $academicYearId);
        })->when($filters['batch_id'] ?? null, function ($query, $batchId) {
            $query->where('batch_id', $batchId);
        })->when($filters['level_id'] ?? null, function ($query, $levelId) {
            $query->where('level_id', $levelId);
        })->when($filters['program_id'] ?? null, function ($query, $programId) {
            $query->where('program_id', $programId);
        });
    }

    // public function existsProgramAndBatch($programId, $batchId, $excludeNames = [])
    // {
    //     $query = $this
    //         ->where('program_id', $programId)
    //         ->where('batch_id', $batchId);

    //     if (!empty($excludeNames)) {
    //         $query = $query->whereNotIn('name', $excludeNames);
    //     }

    //     return $query->exists();
    // }
}
