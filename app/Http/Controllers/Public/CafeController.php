<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Cafe;
use Illuminate\Http\Request;

class CafeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cafes = Cafe::with('tags')->latest()->get();
        return view('public.cafes.index', compact('cafes'));
    }

    /**
     * Display the specified resource (The Menu).
     */
    public function show($slug)
    {
        $cafe = Cafe::with(['products' => function($query) {
            $query->where('is_available', true);
        }, 'products.category', 'tags'])->where('slug', $slug)->firstOrFail();
        
        // Group products by category for the menu view
        $groupedProducts = $cafe->products->groupBy(function($product) {
            return $product->category->name ?? 'Other';
        });

        return view('public.cafes.show', compact('cafe', 'groupedProducts'));
    }
}
