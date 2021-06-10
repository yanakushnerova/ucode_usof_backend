<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('likes')->insert([
            'user_id' => 2,
            'post_id' => 1,
            'comment_id' => null,
            'type' => 'like'
        ]);

        DB::table('likes')->insert([
            'user_id' => 1,
            'post_id' => 1,
            'comment_id' => null,
            'type' => 'dislike'
        ]);

        DB::table('likes')->insert([
            'user_id' => 1,
            'post_id' => 2,
            'comment_id' => null,
            'type' => 'dislike'
        ]);

        DB::table('likes')->insert([
            'user_id' => 4,
            'post_id' => null,
            'comment_id' => 2,
            'type' => 'dislike'
        ]);
    }
}
