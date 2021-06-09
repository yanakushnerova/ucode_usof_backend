<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('posts')->insert([
            'user_id' => 2,
            'title' => 'Is php bad?',
            'status' => 'active',
            'content' => 'Help please',
            'category_id' => 4
        ]);

        // DB::table('posts')->insert([
        //     'user_id' => '2',
        //     'title' => 'Is php bad?',
        //     'status' => 'active',
        //     'content' => 'Help please',
        //     'category_id' => '4'
        // ]);

        // DB::table('posts')->insert([
        //     'user_id' => '2',
        //     'title' => 'Is php bad?',
        //     'status' => 'active',
        //     'content' => 'Help please',
        //     'category_id' => '4'
        // ]);

        // DB::table('posts')->insert([
        //     'user_id' => '2',
        //     'title' => 'Is php bad?',
        //     'status' => 'active',
        //     'content' => 'Help please',
        //     'category_id' => '4'
        // ]);
    }
}
