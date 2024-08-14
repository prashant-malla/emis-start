<?php

namespace App\Services;

use Illuminate\Support\Collection;
use App\Contracts\StaffDirectoryInterface;
use Illuminate\Support\Facades\Hash;

class StaffDirectoryService
{
    public function __construct(protected StaffDirectoryInterface $staff)
    {
    }

    public function getSSR1Reports() : Collection
    {
        return
            $this
                ->staff
                ->getSSR1Reports();
    }

    public function getSSR1ReportsByDepartment($filterBy) : Collection
    {
        return
            $this
                ->staff
                ->getSSR1ReportsByDepartment($filterBy);
    }
    
    public function resetPassword($request)
    {
        $data['password'] = Hash::make($request['password']);

        return $this->staff->updateById($request['user_id'], $data);
    }
}
