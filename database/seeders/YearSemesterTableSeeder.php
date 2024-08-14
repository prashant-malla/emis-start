<?php

namespace Database\Seeders;

use App\Models\YearSemester;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class YearSemesterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $yearSemesters = [
            [
                'level_id' => '1',
                'program_id' => '1',
                'type' => 'year',
                'name' => 'First Year',
            ],
            [
                'level_id' => '1',
                'program_id' => '1',
                'type' => 'year',
                'name' => 'Second Year',
            ],
            [
                'level_id' => '1',
                'program_id' => '1',
                'type' => 'year',
                'name' => 'Third Year',
            ],
            [
                'level_id' => '1',
                'program_id' => '1',
                'type' => 'year',
                'name' => 'Fourth Year',
            ],
            [
                'level_id' => '1',
                'program_id' => '2',
                'type' => 'semester',
                'name' => 'First Semester',
            ],
            [
                'level_id' => '1',
                'program_id' => '2',
                'type' => 'semester',
                'name' => 'Second Semester',
            ],
            [
                'level_id' => '1',
                'program_id' => '2',
                'type' => 'semester',
                'name' => 'Third Semester',
            ],
            [
                'level_id' => '1',
                'program_id' => '2',
                'type' => 'semester',
                'name' => 'Fourth Semester',
            ],
            [
                'level_id' => '1',
                'program_id' => '2',
                'type' => 'semester',
                'name' => 'Fifth Semester',
            ],
            [
                'level_id' => '1',
                'program_id' => '2',
                'type' => 'semester',
                'name' => 'Sixth Semester',
            ],
            [
                'level_id' => '1',
                'program_id' => '2',
                'type' => 'semester',
                'name' => 'Seventh Semester',
            ],
            [
                'level_id' => '1',
                'program_id' => '4',
                'type' => 'year',
                'name' => 'First Year',
            ],
            [
                'level_id' => '1',
                'program_id' => '4',
                'type' => 'year',
                'name' => 'Second Year',
            ],
            [
                'level_id' => '1',
                'program_id' => '4',
                'type' => 'year',
                'name' => 'Third Year',
            ],
            [
                'level_id' => '1',
                'program_id' => '4',
                'type' => 'year',
                'name' => 'Fourth Year',
            ],
        ];

        foreach ($yearSemesters as $yearSemester) {
            YearSemester::create($yearSemester);
        }
    }
}
