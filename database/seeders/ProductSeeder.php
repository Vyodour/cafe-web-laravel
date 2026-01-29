<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Cafe;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Early return if cafes or categories don't exist to prevent errors
        $balikpapan = Cafe::where('slug', 'kafe-balikpapan')->first();
        $samarinda = Cafe::where('slug', 'kafe-samarinda')->first();
        
        $coffee = Category::where('slug', 'coffee')->first();
        $snack = Category::where('slug', 'snack')->first();
        $mainCourse = Category::where('slug', 'main-course')->first();

        if (!$balikpapan || !$samarinda || !$coffee || !$snack || !$mainCourse) {
            return;
        }

        // --- Balikpapan Products ---
        Product::create([
            'cafe_id' => $balikpapan->id,
            'category_id' => $coffee->id,
            'name' => 'Kopi Susu Balikpapan',
            'slug' => 'kafe-balikpapan-kopi-susu',
            'description' => 'Kopi susu khas dengan gula aren asli.',
            'price' => 25000,
            'stock_quantity' => 100,
            'is_available' => true,
            'image' => 'https://images.unsplash.com/photo-1541167760496-1628856ab772?q=80&w=1000&auto=format&fit=crop',
        ]);

        Product::create([
            'cafe_id' => $balikpapan->id,
            'category_id' => $snack->id,
            'name' => 'Mantau Balikpapan',
            'slug' => 'kafe-balikpapan-mantau',
            'description' => 'Roti mantau kukus/goreng dengan cocolan sapi lada hitam.',
            'price' => 35000,
            'stock_quantity' => 50,
            'is_available' => true,
            'image' => 'https://images.unsplash.com/photo-1621303837174-89787a7d4729?q=80&w=1000&auto=format&fit=crop',
        ]);

        // --- Samarinda Products ---
        Product::create([
            'cafe_id' => $samarinda->id,
            'category_id' => $coffee->id,
            'name' => 'Kopi Susu Mahakam',
            'slug' => 'kafe-samarinda-kopi-susu-mahakam',
            'description' => 'Kopi robusta kuat menemani nongkrong di tepian Mahakam.',
            'price' => 20000,
            'stock_quantity' => 100,
            'is_available' => true,
            'image' => 'https://images.unsplash.com/photo-1497935586351-b67a49e012bf?q=80&w=1000&auto=format&fit=crop',
        ]);

        Product::create([
            'cafe_id' => $samarinda->id,
            'category_id' => $snack->id,
            'name' => 'Amplang Kuku Macan',
            'slug' => 'kafe-samarinda-amplang',
            'description' => 'Kerupuk ikan tenggiri asli Samarinda.',
            'price' => 15000,
            'stock_quantity' => 200,
            'is_available' => true,
             'image' => 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?q=80&w=1000&auto=format&fit=crop',
        ]);
        
        Product::create([
            'cafe_id' => $samarinda->id,
            'category_id' => $mainCourse->id,
            'name' => 'Nasi Kuning Samarinda',
            'slug' => 'kafe-samarinda-nasi-kuning',
            'description' => 'Nasi kuning dengan lauk ikan haruan masak habang.',
            'price' => 28000,
            'stock_quantity' => 30,
            'is_available' => true,
             'image' => 'https://images.unsplash.com/photo-1596560548464-f010549b84d7?q=80&w=1000&auto=format&fit=crop',
        ]);
    }
}
