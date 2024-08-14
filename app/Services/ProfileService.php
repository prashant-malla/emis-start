<?php

namespace App\Services;

use App\Contracts\ProfileInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileService
{
  private $guards = ['admin', 'student', 'staff'];

  public function __construct(protected ProfileInterface $profile)
  {
  }

  public function getProfile()
  {
    if (Auth::check()) {
      return Auth::user();
    }

    foreach ($this->guards as $guard) {
      if (auth()->guard($guard)->check()) {
        return $this->profile->getProfile($guard);
      }
    }
  }

  public function updateProfile($profile, $data)
  {
    if (isset($data['profile_image'])) {
      if ($profile->hasMedia()) {
        $profile->deleteMedia($profile->getMedia()[0]);
      }

      $profile->addMedia($data['profile_image'])->toMediaCollection();
    }

    if (isset($data['resume'])) {
      $profile->clearMediaCollection('resume');
      $profile->addMedia($data['resume'])->toMediaCollection('resume');
    }

    if (isset($data['joining_letter'])) {
      $profile->clearMediaCollection('joining_letter');
      $profile->addMedia($data['joining_letter'])->toMediaCollection('joining_letter');
    }

    if (isset($data['document'])) {
      $profile->clearMediaCollection('document');
      $profile->addMedia($data['document'])->toMediaCollection('document');
    }

    if (isset($data['slc_certificate'])) {
      $profile->clearMediaCollection('slc_certificate');
      $profile->addMedia($data['slc_certificate'])->toMediaCollection('slc_certificate');
    }

    if (isset($data['high_school_certificate'])) {
      $profile->clearMediaCollection('high_school_certificate');
      $profile->addMedia($data['high_school_certificate'])->toMediaCollection('high_school_certificate');
    }

    if (isset($data['other_certificate'])) {
      $profile->clearMediaCollection('other_certificate');
      $profile->addMedia($data['other_certificate'])->toMediaCollection('other_certificate');
    }

    return $this->profile->updateProfile($profile, $data);
  }

  public function updatePassword($profile, $oldPassword, $password)
  {
    if (!Hash::check($oldPassword, $profile->password)) {
      return false;
    }

    $data['password'] = Hash::make($password);
    return $this->profile->updateProfile($profile, $data);
  }
}
