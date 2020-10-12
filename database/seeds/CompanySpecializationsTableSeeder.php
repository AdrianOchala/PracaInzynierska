<?php

use App\CompanySpecialization;
use Illuminate\Database\Seeder;

class CompanySpecializationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CompanySpecialization::create(['company_id'=>'1','specialization_id'=>'1']);
        CompanySpecialization::create(['company_id'=>'1','specialization_id'=>'2']);
        CompanySpecialization::create(['company_id'=>'1','specialization_id'=>'3']);
        CompanySpecialization::create(['company_id'=>'1','specialization_id'=>'6']);
        CompanySpecialization::create(['company_id'=>'1','specialization_id'=>'10']);
        CompanySpecialization::create(['company_id'=>'5','specialization_id'=>'11']);
        CompanySpecialization::create(['company_id'=>'5','specialization_id'=>'5']);
        CompanySpecialization::create(['company_id'=>'5','specialization_id'=>'2']);
        CompanySpecialization::create(['company_id'=>'5','specialization_id'=>'6']);
        CompanySpecialization::create(['company_id'=>'5','specialization_id'=>'8']);
        CompanySpecialization::create(['company_id'=>'3','specialization_id'=>'11']);
        CompanySpecialization::create(['company_id'=>'3','specialization_id'=>'5']);
        CompanySpecialization::create(['company_id'=>'3','specialization_id'=>'2']);
        CompanySpecialization::create(['company_id'=>'3','specialization_id'=>'6']);
        CompanySpecialization::create(['company_id'=>'3','specialization_id'=>'8']);
    }
}
