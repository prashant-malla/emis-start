<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;
    protected $table = 'programs';
    protected $fillable = ['level_id', 'faculty_id', 'name', 'type', 'admission_fee'];

    public function level()
    {
        return $this->belongsTo('App\Models\Level', 'level_id', 'id');
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }
    public function students()
    {
        return $this->hasMany(Student::class);
    }
    public function non()
    {
        return $this->hasMany(NonCredit::class);
    }
    public function yearSemesters(){
        return $this->hasMany(YearSemester::class);
    }
}
