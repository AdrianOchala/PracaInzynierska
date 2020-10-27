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
        Company::create(['user_id'=>'2','name'=>'Main Company','NIP'=>'8344218562','location'=>'{"lat":50.27872391338665,"lng":18.806905855572532}',
            'city'=>'Chorzów','street'=>'Nomana','zipCode'=>'414', 'phones'=>'[{"number":"45523"},{"number":"678765"}]']);
        Company::create(['user_id'=>'6','name'=>"Adam's Company",'NIP'=>'5412351321','location'=>'{"lat":50.32872391338665,"lng":18.956905855572532}',
            'city'=>'Chorzów','street'=>'Nomana','zipCode'=>'414', 'phones'=>'[{"number":"45523"},{"number":"678765"}]']);
        Company::create(['user_id'=>'7','name'=>'FastFix','NIP'=>'4523452897','location'=>'{"lat":50.31872391338665,"lng":18.956905855572532}',
            'city'=>'Chorzów','street'=>'Nomana','zipCode'=>'414', 'phones'=>'[{"number":"45523"},{"number":"678765"}]']);
        Company::create(['user_id'=>'8','name'=>'RepairMaster','NIP'=>'4511152897','location'=>'{"lat":50.32699292377332,"lng":18.89315571435548}',
            'city'=>'Chorzów','street'=>'Nomana','zipCode'=>'414', 'phones'=>'[{"number":"45523"},{"number":"678765"}]']);
        Company::create(['user_id'=>'9','name'=>'TrustUs','NIP'=>'4511442897','location'=>'{"lat":50.306492662765685,"lng":18.906614132446293}',
            'city'=>'Świętochłowice','street'=>'Chorzowska','zipCode'=>'414', 'phones'=>'[{"number":"45523"},{"number":"678765"}]']);
    }
}
