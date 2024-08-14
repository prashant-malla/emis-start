<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $fillable = ['department'];

    public function staff_directories(){
        return $this->hasMany(StaffDirectory::class);
    }

    public function sub_departments()
    {
        return $this->hasMany(SubDepartment::class);
    }

    public function designations()
    {
        return $this->hasMany(Designation::class);
    }
}
