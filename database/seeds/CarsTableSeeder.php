<?php
use App\Car;
use Illuminate\Database\Seeder;

class CarsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Car::create(['user_id'=>1,'carModel_id'=>142,'type'=>'SUV','production'=>'2019','plate'=>'SL80801','fuel'=>'Benzyna',
            'engine'=>'3.0','transmission'=>'Automatyczna','VIN'=>'ASD123555TFD','service'=>'2020-10-30','mileage'=>'21000']);
        Car::create(['user_id'=>1,'carModel_id'=>762,'type'=>'SUV','production'=>'2018','plate'=>'SL80802','fuel'=>'Benzyna',
            'engine'=>'3.0','transmission'=>'Automatyczna','VIN'=>'ASD12355rrFD','service'=>'2020-12-30','mileage'=>'29900']);
    }
}
