<?php

namespace App\Contracts;

interface ProfileInterface
{
    public function getProfile($guard);

    public function updateProfile($profile, array $profileData);
}
