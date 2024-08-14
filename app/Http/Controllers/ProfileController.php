<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Sparent;
use App\Services\ProfileService;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    private $fillableAdminFields = ['name', 'email', 'profile_image'];
    private $fillableStudentFields = [
      'sname',
      'email',
      'phone',
      'gender',
      'bloodgroup',
      'dob',
      'caste',
      'religion',
      'caddress',
      'paddress',
      'parent_email',
      'father_name',
      'father_contact',
      'father_job',
      'mother_name',
      'mother_contact',
      'mother_job',
      'profile_image',
      'slc_certificate',
      'high_school_certificate',
      'other_certificate',
    ];
    private $fillableStaffFields = [    
      'name',
      'email',
      'phone',
      'gender',
      'dob',
      'marital_status',
      'current_address',
      'permanent_address',
      'emergency_phone',
      'father_name',
      'mother_name',
      'pan_number',
      'work_shift',
      'bank_name',
      'bank_account_name',
      'bank_account_number',
      'bank_branch_name',
      'facebook_link',
      'instagram_link',
      'twitter_link',
      'linkedin_link',
      'profile_image',
      'resume',
      'joining_letter',
      'document',
    ];
    private $fillableParentFields = [    
        'parent_email',
        'father_name',
        'father_contact',
        'father_job',
        'mother_name',
        'mother_contact',
        'mother_job',
    ];
    
    public function __construct(
        protected ProfileService $profile
    ) {
    }

    public function show()
    {
        $data['title'] = 'Profile';
        $data['profile'] = $this->profile->getProfile();
        return view('profile.show', $data);
    }

    public function edit()
    {
        $data['title'] = 'Edit Profile';
        $data['profile'] = $this->profile->getProfile();
        return view('profile.edit', $data);
    }

    public function update(UpdateProfileRequest $request)
    {
        $profile = $this->profile->getProfile();
        
        $isAdmin = Auth::check();
        $isStaff = !$isAdmin && Auth::guard('staff')->check();
        $isStudent = !$isAdmin && !$isStaff && Auth::guard('student')->check();

        if($isStudent){
            $fillableFields = $this->fillableStudentFields;
        }else if($isStaff){
            $fillableFields = $this->fillableStaffFields;
        }else{
            $fillableFields = $this->fillableAdminFields;
        }

        $data = $request->only($fillableFields);
        $this->profile->updateProfile($profile, $data);

        // save parent information
        if($isStudent){
            $parent = Sparent::where('student_id', $profile->id);
            if($parent){
                $data = $request->only($this->fillableParentFields);
                if(isset($data['parent_email'])){
                    $data['email'] = $data['parent_email'];
                    unset($data['parent_email']);
                }
                $this->profile->updateProfile($parent, $data);               
            }
        }

        return redirect()->route('profile.show')->with('success', 'Profile updated Successfully.');
    }

    public function editPassword()
    {
        $data['title'] = 'Change Password';
        return view('profile.edit-password', $data);
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $profile = $this->profile->getProfile();
        $success = $this->profile->updatePassword($profile, $request->validated('old_password'), $request->validated('password'));

        if (!$success) {
            return redirect()->back()->with('error', 'Old password did not match.');
        }

        return redirect()->route('profile.show')->with('success', 'Password updated Successfully.');
    }
}
