<?php

use App\Comment;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Comment::create(['user_id'=>'1','company_id'=>'3','rating'=>'3.5','comment'=>'Całkiem przyzwoicie wykonana praca aczkolwiek brudno w samochodzie']);

    }
}
