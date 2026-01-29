<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            'Free Wifi',
            'Outdoor Area',
            'Indoor AC',
            'Live Music',
            'Coworking Space',
            'Pet Friendly',
            '24 Hours',
            'Musholla',
            'Natural'
        ];

        foreach ($tags as $tag) {
            Tag::create(['name' => $tag]);
        }
    }
}
