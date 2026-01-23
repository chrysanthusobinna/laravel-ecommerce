<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            CountrySeeder::class,
            CategorySeeder::class,
            SizeSeeder::class,
            ProductLabelSeeder::class,
            ProductSeeder::class,
            CompanyAddressSeeder::class,
            CompanyWorkingHoursSeeder::class,
        ]);

 
    }
}
