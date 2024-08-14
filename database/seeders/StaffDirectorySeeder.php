<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\StaffDirectory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class StaffDirectorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StaffDirectory::factory()
            ->count(2)
            ->state(new Sequence(
                ['role_id' => Role::where('role', 'Teacher')->first()->id],
                ['role_id' => Role::where('role', 'Accountant')->first()->id],
            ))
            ->create();
    }
}
