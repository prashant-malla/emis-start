<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeBill extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'bill_number', 'sequence_number', 'total_amount'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }
}
