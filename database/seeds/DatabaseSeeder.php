<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(SpecializationsTableSeeder::class);
        $this->call(CompaniesTableSeeder::class);
        $this->call(CommentsTableSeeder::class);
        $this->call(CompanySpecializationsTableSeeder::class);
        $this->call(CarBrandsTableSeeder::class);
        $this->call(CarModelsTableSeeder::class);

    }
}
