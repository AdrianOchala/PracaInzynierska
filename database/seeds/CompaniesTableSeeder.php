<?php
use App\Company;
use Illuminate\Database\Seeder;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::create(['user_id'=>'1','name'=>'Adrians Company','NIP'=>'4','location'=>'{"lat":50.29872391338665,"lng":18.956905855572532}',
            'city'=>'Chorzów','street'=>'Nomana','zipCode'=>'414', 'phones'=>'[{"number":"45523"},{"number":"678765"}]']);
        Company::create(['user_id'=>'3','name'=>'Jonas Company','NIP'=>'5','location'=>'{"lat":50.32872391338665,"lng":18.956905855572532}',
            'city'=>'Chorzów','street'=>'Nomana','zipCode'=>'414', 'phones'=>'[{"number":"45523"},{"number":"678765"}]']);
        Company::create(['user_id'=>'2','name'=>'Agata Company','NIP'=>'6','location'=>'{"lat":50.30872391338665,"lng":18.956905855572532}',
            'city'=>'Chorzów','street'=>'Nomana','zipCode'=>'414', 'phones'=>'[{"number":"45523"},{"number":"678765"}]']);
        Company::create(['user_id'=>'4','name'=>'Sonias Company','NIP'=>'7','location'=>'{"lat":50.31872391338665,"lng":18.956905855572532}',
            'city'=>'Chorzów','street'=>'Nomana','zipCode'=>'414', 'phones'=>'[{"number":"45523"},{"number":"678765"}]']);
        Company::create(['user_id'=>'5','name'=>'Iza Company','NIP'=>'8','location'=>'{"lat":50.29672391338665,"lng":18.956905855572532}',
            'city'=>'Chorzów','street'=>'Nomana','zipCode'=>'414', 'phones'=>'[{"number":"45523"},{"number":"678765"}]']);
    }
}
