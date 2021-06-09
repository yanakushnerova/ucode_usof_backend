<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'login' => 'admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'role' => 'admin'
        ]);

        DB::table('users')->insert([
            'login' => 'user1',
            'username' => 'user1 user',
            'email' => 'user1@gmail.com',
            'password' => Hash::make('user1'),
            'role' => 'user'
        ]);

        DB::table('users')->insert([
            'login' => 'Vova',
            'username' => 'Vova Ponomarenko',
            'email' => 'ponomarenko@gmail.com',
            'password' => Hash::make('Vova'),
            'role' => 'user'
        ]);

        DB::table('users')->insert([
            'login' => 'aboba',
            'username' => 'aboba',
            'email' => 'aboba@gmail.com',
            'password' => Hash::make('aboba'),
            'role' => 'user'
        ]);

        DB::table('users')->insert([
            'login' => 'user2',
            'username' => 'user2',
            'email' => 'user2@gmail.com',
            'password' => Hash::make('user2'),
            'role' => 'user'
        ]);
    }
}
