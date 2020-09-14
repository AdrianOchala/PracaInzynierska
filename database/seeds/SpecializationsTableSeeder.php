<?php

use App\Specialization;
use Illuminate\Database\Seeder;

class SpecializationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Specialization::create(['name'=>'Auto Gaz']);
        Specialization::create(['name'=>'Rozruszniki']);
        Specialization::create(['name'=>'Skrzynie biegów']);
        Specialization::create(['name'=>'Elektryka']);
        Specialization::create(['name'=>'Blacharka']);
        Specialization::create(['name'=>'Nagłośnienie']);

    }
}
