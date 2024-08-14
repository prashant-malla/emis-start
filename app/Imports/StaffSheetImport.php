<?php

namespace App\Imports;

use App\Models\Department;
use App\Models\Designation;
use App\Models\Role;
use App\Models\StaffDirectory;
use App\Models\SubDepartment;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class StaffSheetImport implements ToModel, WithStartRow, SkipsEmptyRows
{
    public function startRow(): int
    {
        return 2;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // remove spaces from data
        $row = collect($row)->map(function ($item) {
            return is_string($item) ? trim($item) : $item;
        })->toArray();

        $staff = StaffDirectory::where('staff_id', $row[0])->first();
        if ($staff)  throw new \Exception('Staff ID already exists');

        if (!$row[1]) throw new \Exception('Name not found');

        $role = Role::where('role', $row[2])->first();
        if (!$role) throw new \Exception('Role not found');

        $department = Department::where('department', $row[3])->first();
        if (!$department) throw new \Exception('Department not found');

        $designation = Designation::where('title', $row[4])->first();
        if (!$designation) throw new \Exception('Designation not found');

        // convert to actual date format(sometime excel stores date as numeric value)
        if ($row[12]) {
            if (is_integer($row[12])) {
                $row[12] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[12])->format('Y-m-d');
            } else {
                if (strpos($row[12], '/') !== false) {
                    $dobItems = explode('/', $row[12]);
                    if (strlen($dobItems[0]) === 4) {
                        // 2057/04/32
                        $row[12] = implode('-', $dobItems);
                    } else {
                        // 4/32/2057
                        $row[12] = $dobItems[2] . '-' . $dobItems[0] . '-' . $dobItems[1];
                    }
                } else {
                    // 2057-04-32
                }
            }
        }

        //* if student email($row[10]) is empty then generate fake email
        if (!$row[10]) {
            $name = strtolower(str_replace(' ', '', $row[1]));
            $row[10] =  $name . rand(1000, 9999) . '@gmail.com';
        }

        //* if phone number($row[11]) is empty then generate fake phone number
        if (!$row[11]) {
            $row[11] = generateTenDigit();
        }

        return new StaffDirectory([
            'staff_id' => $row[0],
            'name' => $row[1],
            'role_id' => $role->id,
            'department_id' => $department->id,
            'designation_id' => $designation->id,
            'sub_department_id' => SubDepartment::where('name', $row[5])->first()->id ?? null,
            'gender' => $row[6],
            'ethnicity' => $row[7] ?? 'Others',
            'contract_type' => $row[8] === 'Full Time' ? 'full_time' : 'part_time',
            'service_type' => $row[9] ? strtolower($row[9]) : '',
            'email' => $row[10],
            'phone' => (string)$row[11],
            'password' => Hash::make($row[11]),
            'dob' => $row[12] ?? null,
            'marital_status' => $row[13] ?? null,
            'permanent_address' => $row[14] ?? null,
            'current_address' => $row[15] ?? null,
            'qualification' => $row[16] ?? null,
            'work_experience' => $row[17] ?? null,
            'father_name' => $row[18] ?? null,
            'mother_name' => $row[19] ?? null,
            'emergency_phone' => $row[20] ?? null,
        ]);
    }
}
