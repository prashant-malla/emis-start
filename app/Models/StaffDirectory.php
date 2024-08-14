<?php

namespace App\Models;

use App\Casts\SystemDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Foundation\Auth\User as Authenticatable;


class StaffDirectory extends Authenticatable implements HasMedia
{
    use HasFactory, InteractsWithMedia, HasApiTokens;

    protected $fillable = [
        'staff_id', 'name', 'email', 'password', 'phone', 'gender', 'dob', 'marital_status', 'permanent_address', 'current_address',
        'qualification', 'work_experience', 'father_name', 'mother_name', 'emergency_phone', 'role_id', 'ethnicity',
        'designation_id', 'department_id', 'sub_department_id', 'date_of_joining', 'note', 'pan_number', 'work_shift', 'service_type',
        'basic_salary', 'bank_name', 'bank_account_name', 'bank_account_number', 'bank_branch_name',
        'facebook_link', 'instagram_link', 'twitter_link', 'linkedin_link', 'status', 'section_id', 'year_semester_id', 'program_id', 'level_id', 'contract_type'
    ];

    protected $appends = ['profile_image', 'resume', 'joining_letter', 'document'];

    public function getProfileImageAttribute($value)
    {
        return $this->hasMedia() ? $this->getMedia()[0]->getFullUrl() : '/template/images/icons/user-icon.jpg';
    }
    public function getResumeAttribute($value)
    {
        return $this->hasMedia('resume') ? $this->getMedia('resume')[0]->getFullUrl() : '';
    }
    public function getJoiningLetterAttribute($value)
    {
        return $this->hasMedia('joining_letter') ? $this->getMedia('joining_letter')[0]->getFullUrl() : '';
    }
    public function getDocumentAttribute($value)
    {
        return $this->hasMedia('document') ? $this->getMedia('document')[0]->getFullUrl() : '';
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id', 'id');
    }
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
    public function sub_department()
    {
        return $this->belongsTo(SubDepartment::class, 'sub_department_id', 'id');
    }
    public function issue_items()
    {
        return $this->hasMany(IssueItem::class);
    }
    public function homework()
    {
        return $this->hasMany(Homework::class);
    }
    public function level()
    {
        return $this->belongsTo('App\Models\Level', 'level_id', 'id');
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
    //    public function library__member(){
    //        return $this->hasOne(LibraryStaffMember::class, 'directory_id', 'id');
    //    }

    //    public function leave_requests()
    //    {
    //        return $this->hasMany(LeaveRequest::class);
    //    }
    public function library_member()
    {
        return $this->hasOne(LibraryMember::class, 'directory_id', 'id');
    }

    public function teacher_assigns()
    {
        return $this->hasMany(TeacherAssign::class, 'teacher_id', 'id');
    }

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
        'dob' => SystemDate::class,
        'date_of_joining' => SystemDate::class,
    ];
}
