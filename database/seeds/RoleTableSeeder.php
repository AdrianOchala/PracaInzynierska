<?php

use Illuminate\Database\Seeder;
use App\Role;
class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name'=>'Admin','permission'=>'[{"resourceName":"Szukaj mechanika","read":true,"write":true,"update":true,"delete":true,"name":"SearchMechanic"},{"resourceName":"Zarządzanie rolami","read":true,"write":true,"update":true,"delete":true,"name":"AdminRoleManagement"},{"resourceName":"Mój samochód","read":true,"write":true,"update":true,"delete":true,"name":"UserCar"}]']);
        Role::create(['name'=>'User']);
        Role::create(['name'=>'Owner']);
    }
}
