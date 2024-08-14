<?php

namespace App\Contracts;

use App\Models\StaffDirectory;
use Illuminate\Support\Collection;

interface StaffDirectoryInterface
{
    public function getSSR1Reports() : Collection;
    public function getSSR1ReportsByDepartment($filterBy) : Collection;
    public function updateById($id, array $data) : StaffDirectory;
}
