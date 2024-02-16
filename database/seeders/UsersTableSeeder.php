<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('admin'),
                'role' => 'admin',
            ],
            [
                'name' => 'user',
                'email' => 'user@user.com',
                'password' => bcrypt('user'),
                'role' => 'user',
            ],
        ]);
    }
}
