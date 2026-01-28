<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Traits\HasJsonLogging;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    use HasJsonLogging;

    public function index()
    {
        $this->logAction('view_products_list');
        $products = Product::with('category')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        if (request()->ajax() || request('ajax')) {
            return view('admin.products.partials.create-form', compact('categories'))->render();
        }
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
            'is_available' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $validated['slug'] = \Illuminate\Support\Str::slug($validated['name']) . '-' . \Illuminate\Support\Str::random(5);
        
        // Ensure a cafe exists
        $cafe = \App\Models\Cafe::first();
        if (!$cafe) {
            $cafe = \App\Models\Cafe::create([
                'name' => 'Default Cafe',
                'slug' => 'default-cafe',
                'description' => 'Automatically created default cafe.',
                'address' => 'Default Address',
                'phone' => '0000000000',
                'email' => 'admin@example.com',
            ]);
        }
        $validated['cafe_id'] = $cafe->id;

        $product = Product::create($validated);

        $this->logAction('create_product', ['product_id' => $product->id, 'name' => $product->name]);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        $this->logAction('view_product_details', ['product_id' => $product->id]);
        if (request()->ajax() || request('ajax')) {
            return view('admin.products.partials.show-details', compact('product'))->render();
        }
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        if (request()->ajax() || request('ajax')) {
            return view('admin.products.partials.edit-form', compact('product', 'categories'))->render();
        }
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
            'is_available' => 'boolean',
        ]);

        if ($request->input('delete_image') == '1' && $product->image) {
            Storage::disk('public')->delete($product->image);
            $validated['image'] = null;
        }

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        $this->logAction('update_product', ['product_id' => $product->id, 'changes' => $product->getChanges()]);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        
        $product->delete();

        $this->logAction('delete_product', ['product_id' => $product->id, 'name' => $product->name]);

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}
