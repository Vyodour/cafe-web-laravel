<?php

namespace Database\Seeders;

use App\Models\Cafe;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class CafeTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $balikpapan = Cafe::where('slug', 'kafe-balikpapan')->first();
        $samarinda = Cafe::where('slug', 'kafe-samarinda')->first();
        
        $wifi = Tag::where('name', 'Free Wifi')->first();
        $outdoor = Tag::where('name', 'Outdoor Area')->first();
        $liveMusic = Tag::where('name', 'Live Music')->first();
        $ac = Tag::where('name', 'Indoor AC')->first();

        // Attach tags if they exist
        if ($balikpapan && $wifi && $ac && $outdoor) {
            $balikpapan->tags()->syncWithoutDetaching([$wifi->id, $ac->id, $outdoor->id]);
        }

        if ($samarinda && $wifi && $outdoor && $liveMusic) {
            $samarinda->tags()->syncWithoutDetaching([$wifi->id, $outdoor->id, $liveMusic->id]);
        }
    }
}
