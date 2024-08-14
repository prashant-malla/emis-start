<?php

namespace App\Models;

use App\Casts\SystemDate;
use App\Models\YearSemester;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class NonCredit extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, InteractsWithMedia;

    protected $table = 'non_credits';

    protected $fillable = [
        'course_year',
        'title',
        'first_name',
        'middle_name',
        'last_name',
        'level_id',
        'program_id',
        'year_semester_id',
        'province',
        'district',
        'mv_address',
        'tole',
        'ward',
        'contact',
        'mail',
        'dob',
        'course_cost',
        'tuition_fee',
        'student_id',
        'section_id'
    ];

    protected $appends = ['qr_code'];

    protected $casts = [
        'dob' => SystemDate::class,
    ];

    public function level()
    {
        return $this->belongsTo('App\Models\Level', 'level_id', 'id');
    }

    public function program()
    {
        return $this->belongsTo('App\Models\Program', 'program_id', 'id');
    }

    /**
     * Get the group that owns the NonCredit
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Section::class, 'section_id', 'id');
    }

    /**
     * Get the yearSemester that owns the NonCredit
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function yearSemester(): BelongsTo
    {
        return $this->belongsTo(YearSemester::class);
    }

    public function getQrCodeAttribute()
    {
        return $this->hasMedia() ? $this->getMedia()[0]->getFullUrl() : '';
    }

    public function getFullNameAttribute()
    {
        return
            $this->first_name . ' ' .
            ($this->middle_name ? ($this->middle_name . ' ') : '') .
            $this->last_name;
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
