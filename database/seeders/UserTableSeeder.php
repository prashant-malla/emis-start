<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->create([
                'name' => 'Super Admin',
                'email' => 'superadmin@test.com',
                'password' => bcrypt('iet@pass345'),
                'role' => 'superadmin',
            ]);
    }
}
