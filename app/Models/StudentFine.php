<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentFine extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'date',
        'title',
        'amount',
        'is_paid',
    ];

    public function scopeUnPaid($query)
    {
        return $query->where('is_paid', 0);
    }
}
