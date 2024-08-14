<?php

namespace Database\Seeders;

use App\Models\SchoolSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SchoolSetting::create([
            'name' => 'Test School',
            'session_id' => 1,
            'calendar_type' => 'np',
            'date_format' => 'YYYY-mm-dd'
        ]);
    }
}
