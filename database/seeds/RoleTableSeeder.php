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
        Role::create(['name'=>'Admin','permission'=>'[{"resourceName":"Szukaj mechanika","read":true,"write":true,"update":true,"delete":true,"name":"SearchMechanic"},{"resourceName":"Mój warsztat","read":true,"write":true,"update":true,"delete":true,"name":"OwnerCompany"},{"resourceName":"Mój samochód","read":true,"write":true,"update":true,"delete":true,"name":"UserCar"},{"resourceName":"Moje naprawy","read":true,"write":true,"update":true,"delete":true,"name":"UserRepair"},{"resourceName":"Wiadomości","read":true,"write":true,"update":true,"delete":true,"name":"UserMessages"},{"resourceName":"Zarządzanie rolami","read":true,"write":true,"update":true,"delete":true,"name":"AdminRoleManagement"},{"resourceName":"Zarządzanie użytkownikami","read":true,"write":true,"update":true,"delete":true,"name":"AdminUsersManagement"},{"resourceName":"Zgłoszenia","read":true,"write":true,"update":true,"delete":true,"name":"AdminReportsManagement"}]']);
        Role::create(['name'=>'User','permission'=>'[{"resourceName":"Szukaj mechanika","read":true,"write":true,"update":true,"delete":true,"name":"SearchMechanic"},{"resourceName":"Mój warsztat","read":true,"write":true,"update":true,"delete":true,"name":"OwnerCompany"},{"resourceName":"Mój samochód","read":true,"write":true,"update":true,"delete":true,"name":"UserCar"},{"resourceName":"Moje naprawy","read":true,"write":true,"update":true,"delete":true,"name":"UserRepair"},{"resourceName":"Wiadomości","read":true,"write":true,"update":true,"delete":true,"name":"UserMessages"},{"resourceName":"Zarządzanie rolami","read":false,"write":false,"update":false,"delete":false,"name":"AdminRoleManagement"},{"resourceName":"Zarządzanie użytkownikami","read":false,"write":false,"update":false,"delete":false,"name":"AdminUsersManagement"},{"resourceName":"Zgłoszenia","read":false,"write":false,"update":false,"delete":false,"name":"AdminReportsManagement"}]']);
        Role::create(['name'=>'Owner','permission'=>'[{"resourceName":"Szukaj mechanika","read":true,"write":true,"update":true,"delete":true,"name":"SearchMechanic"},{"resourceName":"Mój warsztat","read":true,"write":true,"update":true,"delete":true,"name":"OwnerCompany"},{"resourceName":"Mój samochód","read":true,"write":true,"update":true,"delete":true,"name":"UserCar"},{"resourceName":"Moje naprawy","read":true,"write":true,"update":true,"delete":true,"name":"UserRepair"},{"resourceName":"Wiadomości","read":true,"write":true,"update":true,"delete":true,"name":"UserMessages"},{"resourceName":"Zarządzanie rolami","read":false,"write":false,"update":false,"delete":false,"name":"AdminRoleManagement"},{"resourceName":"Zarządzanie użytkownikami","read":false,"write":false,"update":false,"delete":false,"name":"AdminUsersManagement"},{"resourceName":"Zgłoszenia","read":false,"write":false,"update":false,"delete":false,"name":"AdminReportsManagement"}]']);
    }
}
