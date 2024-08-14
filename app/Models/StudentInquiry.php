<?php

namespace App\Models;

use App\Models\Section;
use App\Casts\SystemDate;
use App\Models\YearSemester;
use Spatie\MediaLibrary\HasMedia;
use App\Enum\StudentInquiryStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentInquiry extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name',
        'email',
        'ethnicity',
        'level_id',
        'program_id',
        'year_semester_id',
        'section_id',
        'bloodgroup',
        'gender',
        'dob',
        'phone',
        'caddress',
        'paddress',
        'caste',
        'religion',
        'status',

        // parents information
        'parent_email',
        'father_name',
        'father_contact',
        'father_job',
        'mother_name',
        'mother_contact',
        'mother_job',
        'guardian_name',
        'guardian_email',
        'guardian_relation',
        'guardian_job',
        'guardian_contact',
        'guardian_address'
    ];

    protected $casts = [
        'dob' => SystemDate::class,
        'status' => StudentInquiryStatusEnum::class,
    ];

    /**
     * Get the level that owns the StudentInquiry
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function level(): BelongsTo
    {
        return $this->belongsTo('App\Models\Level', 'level_id', 'id');
    }

    /**
     * Get the program that owns the StudentInquiry
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo('App\Models\Program', 'program_id', 'id');
    }

    /**
     * Get the yearSemester that owns the StudentInquiry
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function yearSemester(): BelongsTo
    {
        return $this->belongsTo(YearSemester::class, 'year_semester_id', 'id');
    }

    /**
     * Get the section that owns the StudentInquiry
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class, 'section_id', 'id');
    }

    public function getProfileImageAttribute($value)
    {
        return $this->hasMedia() ? $this->getMedia()[0]->getFullUrl() : '/template/images/icons/user-icon.jpg';
    }
    public function getSlcCertificateAttribute($value)
    {
        return $this->hasMedia('slc_certificate') ? $this->getMedia('slc_certificate')[0]->getFullUrl() : '';
    }
    public function getHighSchoolCertificateAttribute($value)
    {
        return $this->hasMedia('high_school_certificate') ? $this->getMedia('high_school_certificate')[0]->getFullUrl() : '';
    }
    public function getOtherCertificateAttribute($value)
    {
        return $this->hasMedia('other_certificate') ? $this->getMedia('other_certificate')[0]->getFullUrl() : '';
    }
}
