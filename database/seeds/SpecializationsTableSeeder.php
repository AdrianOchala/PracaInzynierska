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
        Specialization::create(['name'=>'Mechanika samochodowa']);
        Specialization::create(['name'=>'Instalacje LPG']);
        Specialization::create(['name'=>'Rozruszniki']);
        Specialization::create(['name'=>'Serwis klimatyzacji']);
        Specialization::create(['name'=>'Skrzynie biegów']);
        Specialization::create(['name'=>'Elektryka']);
        Specialization::create(['name'=>'Wulkanizacja']);
        Specialization::create(['name'=>'Blacharz']);
        Specialization::create(['name'=>'Szyby samochodowe']);
        Specialization::create(['name'=>'Nagłośnienie']);
        Specialization::create(['name'=>'Diesel serwis']);
        Specialization::create(['name'=>'Układ wydechowy']);
        Specialization::create(['name'=>'Manualne skrzynie biegów']);
        Specialization::create(['name'=>'Automatyczne skrzynie biegów']);
        Specialization::create(['name'=>'Regeneracja filtrów DPF']);
        Specialization::create(['name'=>'Chiptuning']);

    }
}
