<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoticeBoard extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'notice_date',
        'notice_to',
        'message',
        'role_id',
        'level_id',
        'program_id',
        'section_id',
    ];

    public function roles()
    {
        return $this->hasMany(Role::class, 'role_id', 'id');
    }
    public function levels()
    {
        return $this->hasMany(Level::class, 'level_id', 'id');
    }
    public function programs()
    {
        return $this->hasMany(Program::class, 'program_id', 'id');
    }
    public function sections()
    {
        return $this->hasMany(Section::class, 'section_id', 'id');
    }
}
