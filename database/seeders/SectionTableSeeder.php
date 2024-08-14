<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Section;

class SectionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sections = [
            [
                'level_id' => '1',
                'program_id' => '1',
                'year_semester_id' => '1',
                'group_name' => 'Group A',
            ],
            [
                'level_id' => '1',
                'program_id' => '1',
                'year_semester_id' => '1',
                'group_name' => 'Group B',
            ],
            [
                'level_id' => '1',
                'program_id' => '1',
                'year_semester_id' => '2',
                'group_name' => 'Group A',
            ],
            [
                'level_id' => '1',
                'program_id' => '1',
                'year_semester_id' => '2',
                'group_name' => 'Group B',
            ],
            [
                'level_id' => '1',
                'program_id' => '1',
                'year_semester_id' => '3',
                'group_name' => 'Group A',
            ],
            [
                'level_id' => '1',
                'program_id' => '1',
                'year_semester_id' => '3',
                'group_name' => 'Group B',
            ],
            [
                'level_id' => '1',
                'program_id' => '1',
                'year_semester_id' => '4',
                'group_name' => 'Group A',
            ],
            [
                'level_id' => '1',
                'program_id' => '1',
                'year_semester_id' => '4',
                'group_name' => 'Group B',
            ],
            [
                'level_id' => '1',
                'program_id' => '2',
                'year_semester_id' => '5',
                'group_name' => 'Group A',
            ],
            [
                'level_id' => '1',
                'program_id' => '2',
                'year_semester_id' => '5',
                'group_name' => 'Group B',
            ],
            [
                'level_id' => '1',
                'program_id' => '2',
                'year_semester_id' => '6',
                'group_name' => 'Group A',
            ],
            [
                'level_id' => '1',
                'program_id' => '2',
                'year_semester_id' => '6',
                'group_name' => 'Group B',
            ],
            [
                'level_id' => '1',
                'program_id' => '4',
                'year_semester_id' => '12',
                'group_name' => 'Group A',
            ],
            [
                'level_id' => '1',
                'program_id' => '4',
                'year_semester_id' => '12',
                'group_name' => 'Group B',
            ],
            [
                'level_id' => '1',
                'program_id' => '4',
                'year_semester_id' => '12',
                'group_name' => 'Group C',
            ],
            [
                'level_id' => '1',
                'program_id' => '4',
                'year_semester_id' => '13',
                'group_name' => 'Group A',
            ],
            [
                'level_id' => '1',
                'program_id' => '4',
                'year_semester_id' => '12',
                'group_name' => 'Group B',
            ],
            [
                'level_id' => '1',
                'program_id' => '4',
                'year_semester_id' => '13',
                'group_name' => 'Group A',
            ],
            [
                'level_id' => '1',
                'program_id' => '4',
                'year_semester_id' => '13',
                'group_name' => 'Group B',
            ],
            [
                'level_id' => '1',
                'program_id' => '4',
                'year_semester_id' => '13',
                'group_name' => 'Group C',
            ],
        ];

        foreach ($sections as $section) {
            Section::create($section);
        }
    }
}
