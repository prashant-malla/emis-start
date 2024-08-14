<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibraryMember extends Model
{
    use HasFactory;
    protected $fillable = ['directory_id', 'student_id', 'library_card_number', 'member_type', 'status', 'qr_code', 'reason', 'removed_date', 'removed_by'];

    public function staff(){
        return $this->hasOne(StaffDirectory::class, 'id', 'directory_id');
    }

    public function staffDirectory(){
        return $this->hasOne(StaffDirectory::class, 'id', 'removed_by');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }
}
