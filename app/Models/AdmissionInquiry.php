<?php

namespace App\Models;

use App\Casts\SystemDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmissionInquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'phone',
        'email',
        'address',
        'description',
        'note',
        'inquiry_date',
        'follow_up',
        'source_id',
        'reference_id',
        'level_id',
        'program_id',
        'year_semester_id',
        'no_of_child',
    ];

    protected $casts = [
        'inquiry_date' => SystemDate::class,
        'follow_up' => SystemDate::class
    ];

    public function source()
    {
        return $this->belongsTo('App\Models\Source', 'source_id', 'id');
    }
    public function reference()
    {
        return $this->belongsTo('App\Models\Reference', 'reference_id', 'id');
    }
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
}
