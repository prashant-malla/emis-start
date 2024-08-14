<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'role' => 'Admin',
            ],
            [
                'role' => 'Accountant',
            ],
            [
                'role' => 'Librarian',
            ],
            [
                'role' => 'Principle',
            ],
            [
                'role' => 'Teacher',
            ],
            [
                'role' => 'CEO',
            ],
            [
                'role' => 'Campus Chief',
            ],
            [
                'role' => 'Educational Coordinator',
            ],
            [
                'role' => 'Account Officer',
            ],
            [
                'role' => 'Admin Assistance',
            ],
            [
                'role' => 'Office Assistant',
            ],
            [
                'role' => 'Security Guard',
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
