<?php

namespace App\Repositories;

use App\Contracts\StaffDirectoryInterface;
use App\Models\StaffDirectory;
use Illuminate\Support\Collection;

class StaffDirectoryRepository implements StaffDirectoryInterface
{
    public function __construct(protected StaffDirectory $staffDirectory)
    {
    }

    public function getSSR1Reports() : Collection
    {
        return
            $this
                ->staffDirectory
                ->select([
                    'name',
                    'contract_type',
                    'service_type',
                    'date_of_joining',
                    'designation_id',
                    'department_id'
                ])
                ->latest('id')
                ->get()
                ->map(
                    function ($ssr) {
                        return [
                            'fullName' => $ssr->name,
                            'tenureType' => $ssr->contract_type ? ucwords(str_replace("_", " ", $ssr->contract_type)) : '-',
                            'typeOfService' => $ssr->service_type ? ucwords($ssr->service_type) : '-',
                            'dateOfJoining' => $ssr->date_of_joining ?? '-',
                            'designation' => $ssr->designation ? $ssr->designation->title : '-'
                        ];
                    }
                )
        ;
    }

    public function getSSR1ReportsByDepartment($filterBy = 'Faculty Member') : Collection
    {
        return
            $this
                ->staffDirectory
                ->select([
                    'name',
                    'contract_type',
                    'service_type',
                    'date_of_joining',
                    'designation_id',
                    'department_id'
                ])
                ->latest('id')
                ->whereHas('department', function ($query) use ($filterBy) {
                    $query->where('department', $filterBy);
                })
                ->get()
                ->map(
                    function ($ssr) {
                        return [
                            'fullName' => $ssr->name,
                            'tenureType' => $ssr->contract_type ? ucwords(str_replace("_", " ", $ssr->contract_type)) : '-',
                            'typeOfService' => $ssr->service_type ? ucwords($ssr->service_type) : '-',
                            'dateOfJoining' => $ssr->date_of_joining ?? '-',
                            'designation' => $ssr->designation ? $ssr->designation->title : '-'
                        ];
                    }
                )
        ;
    }

    public function updateById($id, $data): StaffDirectory
    {
        return tap($this->staffDirectory->find($id))->update($data);
    }
}
