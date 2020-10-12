<?php

use Illuminate\Database\Seeder;
use App\CarModel;

class CarModelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CarModel::create(['carBrand_id'=>'1', 'name'=>'S3']);
        CarModel::create(['carBrand_id'=>'1', 'name'=>'S4']);
        CarModel::create(['carBrand_id'=>'1', 'name'=>'S6']);
        CarModel::create(['carBrand_id'=>'1', 'name'=>'S8']);
        CarModel::create(['carBrand_id'=>'1', 'name'=>'TT']);
        CarModel::create(['carBrand_id'=>'1', 'name'=>'RS5']);
        CarModel::create(['carBrand_id'=>'1', 'name'=>'RS7']);
        CarModel::create(['carBrand_id'=>'1', 'name'=>'Q7']);
        CarModel::create(['carBrand_id'=>'2', 'name'=>'M1']);
        CarModel::create(['carBrand_id'=>'2', 'name'=>'X3']);
        CarModel::create(['carBrand_id'=>'2', 'name'=>'520d']);

    }
}
