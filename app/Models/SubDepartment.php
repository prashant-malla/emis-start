<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubDepartment extends Model
{
    use HasFactory;
    protected $fillable = ['department_id', 'name'];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function designations()
    {
        return $this->hasMany(Designation::class);
    }
    public function staffs()
    {
        return $this->hasMany(StaffDirectory::class);
    }
}
