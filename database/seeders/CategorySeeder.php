<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Coffee' => 'product-coffee', 
            'Non-Coffee' => 'product-non-coffee',
            'Snack' => 'product-snack',
            'Main Course' => 'product-main-course',
            'Dessert' => 'product-dessert'
        ];

        foreach ($categories as $name => $icon) {
            Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'icon' => $icon,
            ]);
        }
    }
}
