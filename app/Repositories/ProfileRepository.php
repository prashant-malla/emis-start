<?php

namespace App\Repositories;

use App\Contracts\ProfileInterface;

class ProfileRepository implements ProfileInterface
{
  public function __construct()
  {
  }

  public function getProfile($guard)
  {
    return auth()->guard($guard)->user();
  }

  public function updateProfile($profile, $data)
  {
    return $profile->update($data);
  }
}
