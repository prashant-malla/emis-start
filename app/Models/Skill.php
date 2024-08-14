<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'staff_id',
        'user_id',
        'organize',
        'staff',
        'employees',
        'objective',
        'message_to',
    ];

    // public function setFilenamesAttribute($value)
    // {
    //     $this->attributes['report'] = json_encode($value);
    // }

    // public function setCategoryAttribute($value)
    // {
    //     $this->attributes['complaint'] = json_encode($value);
    // }

    // public function getCategoryAttribute($value)
    // {
    //     return $this->attributes['complaint'] = json_decode($value);
    // }

}
