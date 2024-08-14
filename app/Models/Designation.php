<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    use HasFactory;
    protected $fillable = ['department_id', 'sub_department_id', 'title'];

    public function staff_directories(){
        $this->hasMany(StaffDirectory::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
    public function sub_department()
    {
        return $this->belongsTo(SubDepartment::class, 'sub_department_id', 'id');
    }
}
