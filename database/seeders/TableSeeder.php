<?php

namespace Database\Seeders;

use App\Models\Table;
use App\Models\Cafe;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cafes = Cafe::all();

        foreach ($cafes as $cafe) {
            // Create 5 tables for each cafe
            for ($i = 1; $i <= 5; $i++) {
                Table::create([
                    'cafe_id' => $cafe->id,
                    'table_number' => $i,
                    'qr_code_token' => Str::random(32),
                    'status' => 'available',
                ]);
            }
        }
    }
}
