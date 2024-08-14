<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stake extends Model
{
    use HasFactory;
    protected $fillable = [
        'status',
        'objective',
        'area',
        'student_id',
        'staff_id',
        'user_id'
    ];

    protected $casts = [
        'area' => 'array'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function student(){
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function staff(){
        return $this->belongsTo(StaffDirectory::class, 'staff_id', 'id');
    }
}
