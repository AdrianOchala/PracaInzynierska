<?php

use Illuminate\Database\Seeder;
use App\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(['name'=>'Adrian','surname'=>'ochala','email'=>'adrian@gmail.com','password'=>bcrypt('haslo123'),
            'phone'=>'500200100','role_id'=>'1']);
        User::create(['name'=>'Agata','surname'=>'Szymańska','email'=>'agata@gmail.com','password'=>bcrypt('haslo123'),
            'phone'=>'500220100','role_id'=>'3']);
        User::create(['name'=>'Adam','surname'=>'Jonas','email'=>'adam@gmail.com','password'=>bcrypt('haslo123'),
            'phone'=>'500205100','role_id'=>'2']);
    }
}
