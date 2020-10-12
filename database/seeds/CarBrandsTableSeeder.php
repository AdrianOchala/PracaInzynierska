<?php

use App\CarBrand;
use Illuminate\Database\Seeder;

class CarBrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CarBrand::create(['name'=>'Audi']);
        CarBrand::create(['name'=>'BMW']);
    }
}
