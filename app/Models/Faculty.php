<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;

    protected $table = 'faculties';
    protected $fillable = [
        'name'
    ];

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function programs()
    {
        return $this->hasMany(Program::class);
    }
}
