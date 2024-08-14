<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Sparent extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'sparents';
    protected $fillable = [
        'student_id', 'email', 'password',
        'father_name', 'father_contact', 'father_job',
        'mother_name', 'mother_contact', 'mother_job',
        'guardian_name', 'guardian_email', 'guardian_relation',
        'guardian_job', 'guardian_contact', 'guardian_address'
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
