<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'title' => 'HTML',
            'description' => 'HyperText Markup Language',
        ]);

        DB::table('categories')->insert([
            'title' => 'CSS',
            'description' => 'Cascading Style Sheets',
        ]);

        DB::table('categories')->insert([
            'title' => 'JS',
            'description' => 'Java Script',
        ]);

        DB::table('categories')->insert([
            'title' => 'PHP',
            'description' => 'Hypertext Preprocessor',
        ]);

        DB::table('categories')->insert([
            'title' => 'PYTHON',
            'description' => 'Python Programming Language',
        ]);

        DB::table('categories')->insert([
            'title' => 'JAVA',
            'description' => 'Java Programming Language',
        ]);

        DB::table('categories')->insert([
            'title' => 'C#',
            'description' => 'C# Programming Language',
        ]);

        DB::table('categories')->insert([
            'title' => 'C++',
            'description' => 'C++ Programming Language',
        ]);
    }
}
