<?php
use App\Repair;
use Illuminate\Database\Seeder;

class RepairsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Repair::create(['company_id'=>'5','user_id'=>'1','car_id'=>'1','status'=>'Oczekujące','price'=>null,'description'=>'Problem z podjazdem pod większe wzniesienia. Jeśli samochód w połowie załadowany to nie ma o czym mówić','contact'=>'komunikator w aplikacji',
            'category'=>'Samochód traci moc','companyReply'=>null]);
    }
}
