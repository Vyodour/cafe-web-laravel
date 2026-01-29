<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CafeSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            TagSeeder::class,
            CafeTagSeeder::class,
            ProductSeeder::class,
            TableSeeder::class,
        ]);
    }
}
