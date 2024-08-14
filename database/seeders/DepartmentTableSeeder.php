<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = [
            [
                'department' => 'Faculty Member',
            ],
            [
                'department' => 'Non-Teaching',
            ],
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}
