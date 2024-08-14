<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eclass extends Model
{
    use HasFactory;
    protected $fillable = [
        'class_name',
        'description',
    ];
    public function session()
    {
        return $this->hasMany(SessionClass::class);
    }
    public function section()
    {
        return $this->hasMany(Section::class);
    }
    public function student()
    {
        return $this->hasMany(Student::class);
    }
    public function meeting()
    {
        return $this->hasMany(Meeting::class);
    }
}
