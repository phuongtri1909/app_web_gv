<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Unit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Bus;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            WardGovapSeeder::class,
            BusinessTypeSeeder::class,
            CategoryProductBusinessSeeder::class,
            BusinessSeeder::class,
            ContactConsultationsSeeder::class,
            BusinessSupportNeedsSeeder::class,
            UnitSeeder::class,
        ]);
    }
}
