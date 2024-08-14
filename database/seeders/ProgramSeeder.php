<?php

namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $programs = [
            [
                'level_id' => "1",
                'name' => "BBA",
                'type' => "year",
                'admission_fee' => "100000",
            ],
            [
                'level_id' => "1",
                'name' => "BCA",
                'type' => "semester",
                'admission_fee' => "80000",
            ],
            [
                'level_id' => "1",
                'name' => "BIT",
                'type' => "semester",
                'admission_fee' => "75000",
            ],
            [
                'level_id' => "1",
                'name' => "BBS",
                'type' => "year",
                'admission_fee' => "200000",
            ],
            [
                'level_id' => "1",
                'name' => "BSc.CSIT",
                'type' => "semester",
                'admission_fee' => "75000",
            ],
            [
                'level_id' => "2",
                'name' => "MIT",
                'type' => "semester",
                'admission_fee' => "200000",
            ],
            [
                'level_id' => "2",
                'name' => "MSc",
                'type' => "semester",
                'admission_fee' => "200000",
            ],
            [
                'level_id' => "2",
                'name' => "MD",
                'type' => "semester",
                'admission_fee' => "1500000",
            ],
            [
                'level_id' => "2",
                'name' => "MBS",
                'type' => "year",
                'admission_fee' => "30000",
            ],
            [
                'level_id' => "2",
                'name' => "MBA",
                'type' => "semester",
                'admission_fee' => "400000",
            ],
            [
                'level_id' => "3",
                'name' => "Research",
                'type' => "year",
                'admission_fee' => "500000",
            ],
            [
                'level_id' => "4",
                'name' => "Static",
                'type' => "year",
                'admission_fee' => "550000",
            ],
            [
                'level_id' => "4",
                'name' => "Science Communication",
                'type' => "year",
                'admission_fee' => "500000",
            ],
        ];
        foreach ($programs as $program) {
            Program::create($program);
        }
    }
}
