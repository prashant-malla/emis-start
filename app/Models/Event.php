<?php

namespace App\Models;

use App\Casts\SystemDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


class Event extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $fillable = [
        'title',
        'organize',
        'objective',
        'date',
        'venue',
        'participants',
        'report',
    ];

    protected $appends = ['document'];

    protected $casts = [
        'date' => SystemDate::class,
    ];

    // public function setFilenamesAttribute($value)
    // {
    //     $this->attributes['report'] = json_encode($value);
    // }
    public function getDocumentAttribute($value)
    {
        return $this->hasMedia() ? $this->getMedia()[0]->getFullUrl() : '';
    }
    public function roles()
    {
        return $this->belongsToMany(Role::class)->withPivot('role_id', 'event_id');
    }
    public function levels()
    {
        return $this->belongsToMany(Level::class);
    }
    public function programs()
    {
        return $this->belongsToMany(Program::class);
    }
    public function yearsemesters()
    {
        return $this->belongsToMany(YearSemester::class);
    }
    public function sections()
    {
        return $this->belongsToMany(Section::class);
    }
}
