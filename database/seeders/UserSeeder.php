<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Cafe;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get Cafe IDs
        $balikpapan = Cafe::where('slug', 'kafe-balikpapan')->first();
        $samarinda = Cafe::where('slug', 'kafe-samarinda')->first();
        $jakarta = Cafe::where('slug', 'kafe-jakarta')->first();

        // Admin for Kafe Balikpapan
        User::create([
            'name' => 'Admin Balikpapan',
            'email' => 'admin@kafebalikpapan.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'cafe_id' => $balikpapan->id,
        ]);

        // Admin for Kafe Samarinda
        User::create([
            'name' => 'Admin Samarinda',
            'email' => 'admin@kafesamarinda.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'cafe_id' => $samarinda->id,
        ]);
        
        // Admin for Kafe Jakarta
        User::create([
            'name' => 'Admin Jakarta',
            'email' => 'admin@cafejakarta.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'cafe_id' => $jakarta->id,
        ]);

        // Super Admin (No specific cafe, or owns all - logic dependent)
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@webkafe.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin', // Assuming role structure
            'cafe_id' => null,
        ]);
    }
}
