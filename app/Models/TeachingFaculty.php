<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeachingFaculty extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'level_id',
        'program_id',
        'year_semester_id',
        'section_id'
    ];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(StaffDirectory::class, 'teacher_id');
    }

    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function yearsemester(): BelongsTo
    {
        return $this->belongsTo(YearSemester::class);
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }
}
