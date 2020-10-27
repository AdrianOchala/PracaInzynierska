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
        User::create(['name'=>'User','surname'=>'user','email'=>'user@gmail.com','password'=>bcrypt('haslo123'),
            'phone'=>'500200100','role_id'=>'2']);
        User::create(['name'=>'Owner','surname'=>'owner','email'=>'owner@gmail.com','password'=>bcrypt('haslo123'),
            'phone'=>'500300211','role_id'=>'3']);
        User::create(['name'=>'Admin','surname'=>'admin','email'=>'admin@gmail.com','password'=>bcrypt('haslo123'),
            'phone'=>'512100399','role_id'=>'1']);
        User::create(['name'=>'Adrian','surname'=>'Ochała','email'=>'adrian@gmail.com','password'=>bcrypt('haslo123'),
            'phone'=>'504560100','role_id'=>'2']);
        User::create(['name'=>'Agata','surname'=>'Szymańska','email'=>'agata@gmail.com','password'=>bcrypt('haslo123'),
            'phone'=>'500220140','role_id'=>'2']);
        User::create(['name'=>'Adam','surname'=>'Patryk','email'=>'adam@gmail.com','password'=>bcrypt('haslo123'),
            'phone'=>'520205100','role_id'=>'3']);
        User::create(['name'=>'Jan','surname'=>'Kowalski','email'=>'jan@gmail.com','password'=>bcrypt('haslo123'),
            'phone'=>'522205100','role_id'=>'3']);
        User::create(['name'=>'Owner1','surname'=>'owner1','email'=>'owner1@gmail.com','password'=>bcrypt('haslo123'),
            'phone'=>'500300211','role_id'=>'3']);
        User::create(['name'=>'Owner2','surname'=>'owner2','email'=>'owner2@gmail.com','password'=>bcrypt('haslo123'),
            'phone'=>'500300211','role_id'=>'3']);
    }
}
