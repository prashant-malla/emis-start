<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Eclass;

class EclassTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $classes = [
            [
                'class_name' => 'BHM',
                'description' => 'This is program of management.',
            ],
            [
                'class_name' => 'BBS',
                'description' => 'This is program of science.',
            ],
            [
                'class_name' => 'BBA',
                'description' => 'This is program of business and commerce.',
            ],
            [
                'class_name' => 'BIT',
                'description' => 'This is program of computer.',
            ],
        ];
        foreach ($classes as $class) {
            Eclass::create($class);
        }
    }
}
