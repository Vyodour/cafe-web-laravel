<?php

namespace App\Http\Controllers;

use App\Models\Cafe;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class LandingController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // Cache cafes for 60 minutes
        $cafes = Cache::remember('landing_cafes', 60 * 60, function () {
            return Cafe::with('tags')->get();
        });

        // Cache featured products (random selection for now, or based on 'badges') for 60 minutes
        $featuredProducts = Cache::remember('landing_products', 60 * 60, function () {
            return Product::where('is_available', true)
                ->inRandomOrder()
                ->take(6)
                ->get();
        });

        return view('landing.index', compact('cafes', 'featuredProducts'));
    }
}
