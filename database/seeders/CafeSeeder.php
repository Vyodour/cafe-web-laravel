<?php

namespace Database\Seeders;

use App\Models\Cafe;
use Illuminate\Database\Seeder;

class CafeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cafe::create([
            'name' => 'Kafe Balikpapan',
            'slug' => 'kafe-balikpapan',
            'description' => 'Kafe nyaman di jantung kota Balikpapan. Menikmati senja dengan kopi terbaik.',
            'address' => 'Jl. Jenderal Sudirman No. 1, Balikpapan',
            'phone' => '081234567890',
            'email' => 'admin@kafebalikpapan.com',
            'image' => 'https://images.unsplash.com/photo-1554118811-1e0d58224f24?q=80&w=1000&auto=format&fit=crop',
        ]);

        Cafe::create([
            'name' => 'Kafe Samarinda',
            'slug' => 'kafe-samarinda',
            'description' => 'Tempat nongkrong asik di Samarinda dengan pemandangan Sungai Mahakam.',
            'address' => 'Jl. Slamet Riyadi No. 5, Samarinda',
            'phone' => '081298765432',
            'email' => 'admin@kafesamarinda.com',
            'image' => 'https://images.unsplash.com/photo-1559925393-8be0ec4767c8?q=80&w=1000&auto=format&fit=crop',
        ]);

        Cafe::create([
            'name' => 'Kafe Jakarta',
            'slug' => 'kafe-jakarta',
            'description' => 'Kopi urban untuk penikmat hiruk pikuk Jakarta Selatan.',
            'address' => 'Jl. Senopati No. 10, Jakarta Selatan',
            'phone' => '0217654321',
            'email' => 'admin@cafejakarta.com',
            'image' => 'https://images.unsplash.com/photo-1509042239860-f550ce710b93?q=80&w=1000&auto=format&fit=crop',
        ]);

        Cafe::create([
            'name' => 'Kafe GrandCity',
            'slug' => 'kafe-grandcity',
            'description' => 'Kopi urban untuk penikmat hiruk pikuk Jakarta Selatan.',
            'address' => 'Jl. Senopati No. 10, Jakarta Selatan',
            'phone' => '0217654321',
            'email' => 'admin@cafejakarta.com',
            'image' => 'https://images.unsplash.com/photo-1509042239860-f550ce710b93?q=80&w=1000&auto=format&fit=crop',
        ]);
    }
}
