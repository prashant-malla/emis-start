<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class HomeworkSubmission extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [];

    protected $appends = ['files', 'isLate'];

    public function student()
    {
        return $this->belongsTo('App\Models\Student', 'student_id', 'id');
    }

    public function homework()
    {
        return $this->belongsTo('App\Models\Homework', 'homework_id', 'id');
    }

    public function getFilesAttribute()
    {
        return $this->hasMedia() ? $this->getMedia() : [];
    }

    public function getIsLateAttribute()
    {
        $submissionDateTime = new Carbon($this->homework->submission . ' ' . $this->homework->submission_time);
        $submittedDateTime = new Carbon($this->created_at);
        return $submittedDateTime->greaterThan($submissionDateTime);
    }
}
