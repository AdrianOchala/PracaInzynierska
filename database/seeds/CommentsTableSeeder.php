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
        Comment::create(['user_id'=>'4','company_id'=>'3','rating'=>'5','comment'=>'Świetna robota!']);
        Comment::create(['user_id'=>'4','company_id'=>'5','rating'=>'2','comment'=>'Nie jestem zadowolony z obsługi!']);
        Comment::create(['user_id'=>'1','company_id'=>'5','rating'=>'4.5','comment'=>'Tak']);
        Comment::create(['user_id'=>'5','company_id'=>'3','rating'=>'5','comment'=>'Nikt tak szybko nie wymienił mi opon!']);
    }
}
