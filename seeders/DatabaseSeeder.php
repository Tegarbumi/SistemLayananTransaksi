<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
                'role' => 2
            ],
            [
                'name' => 'Pegawai',
                'email' => 'pegawai@gmail.com',
                'password' => Hash::make('password'),
                'role' => 1
            ]
        ]);
    }
}
