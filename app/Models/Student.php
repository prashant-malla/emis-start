<?php

namespace App\Models;

use App\Casts\SystemDate;
use App\Enum\StudentStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;

class Student extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sname', //Student's name
        'email',
        'password',
        'admission', //buniversity registration number
        'roll',
        'crn', // college registration number
        'batch',
        'ethnicity',
        'academic_year_id',
        'batch_id',
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
        'qr_code',
        'status',
        'remarks',
        'status_updated_at'
    ];
    //Students Document's and Files
    protected $appends = ['profile_image', 'slc_certificate', 'high_school_certificate', 'other_certificate'];
    protected $guarded = [];
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
    //For Date of Birth in Nepali Calendar.
    protected $casts = [
        'email_verified_at' => 'datetime',
        'dob' => SystemDate::class,
        'status' => StudentStatusEnum::class,
        'status_updated_at' => SystemDate::class,
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($student) {
            $lastCRN = static::max('crn');
            $student->crn = $lastCRN ? ++$lastCRN : 1;
        });
    }

    //Relation of Student's with other modules(one to many, many to one, one to one and relation with the files and documents)
    public function class()
    {
        return $this->belongsTo('App\Models\Eclass', 'class_id', 'id');
    }
    public function level()
    {
        return $this->belongsTo('App\Models\Level', 'level_id', 'id');
    }
    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
    public function program()
    {
        return $this->belongsTo('App\Models\Program', 'program_id', 'id');
    }
    public function yearsemester()
    {
        return $this->belongsTo('App\Models\YearSemester', 'year_semester_id', 'id');
    }
    public function section()
    {
        return $this->belongsTo('App\Models\Section', 'section_id', 'id');
    }
    public function libraryMember()
    {
        return $this->hasOne(LibraryMember::class, 'student_id', 'id');
    }
    public function parent()
    {
        return $this->hasOne(Sparent::class, 'student_id', 'id');
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

    public function scopeFilterBy($query, $filters)
    {
        $query->when($filters['status'] ?? null, function ($query, $status) {
            $query->where('status', $status);
        })->when($filters['academic_year_id'] ?? null, function ($query, $academicYearId) {
            $query->where('academic_year_id', $academicYearId);
        })->when($filters['batch_id'] ?? null, function ($query, $batchId) {
            $query->where('batch_id', $batchId);
        })->when($filters['level_id'] ?? null, function ($query, $levelId) {
            $query->where('level_id', $levelId);
        })->when($filters['program_id'] ?? null, function ($query, $programId) {
            $query->where('program_id', $programId);
        })->when($filters['year_semester_id'] ?? null, function ($query, $yearSemesterId) {
            $query->where('year_semester_id', $yearSemesterId);
        })->when($filters['section_id'] ?? null, function ($query, $sectionId) {
            $query->where('section_id', $sectionId);
        });
    }

    public function assignFees()
    {
        return $this->hasMany(AssignFee::class);
    }

    public function collectFees(): HasMany
    {
        return $this->hasMany(CollectFee::class);
    }

    public function paidFees(): HasMany
    {
        return $this->hasMany(PaidFee::class);
    }

    public function assignDiscounts()
    {
        return $this->hasMany(AssignDiscount::class);
    }

    public function studentFines()
    {
        return $this->hasMany(StudentFine::class);
    }

    public function optionalSubjects()
    {
        return $this->belongsToMany(Subject::class);
    }

    public function enrollments()
    {
        return $this->hasMany(StudentEnrollment::class);
    }

    public function getEnrollment($yearSemesterId)
    {
        return $this->enrollments()->where('year_semester_id', $yearSemesterId)->first();
    }

    public function promotions()
    {
        return $this->hasMany(StudentPromotion::class);
    }

    public function feeBills()
    {
        return $this->hasMany(FeeBill::class);
    }
}
