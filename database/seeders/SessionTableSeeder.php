<?php

namespace Database\Seeders;

use App\Models\Session;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SessionTableSeeder extends Seeder
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
                'session_year' => '2078/79',
                'status' => 'active',
            ],
            [
                'session_year' => '2079/80',
                'status' => 'active',
            ],
        ];

        foreach ($sections as $section) {
            Session::create($section);
        }
    }
}
