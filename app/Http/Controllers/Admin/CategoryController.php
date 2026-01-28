<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Traits\HasJsonLogging;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    use HasJsonLogging;
    
    // Helper to render view or partial
    private function renderView($view, $data = []) {
        if (request()->ajax()) {
            return view($view, $data)->render(); // Return raw HTML for modal
        }
        return view($view, $data);
    }

    public function index()
    {
        $this->logAction('view_categories_list');
        $categories = Category::withCount('products')->latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        if (request()->ajax() || request('ajax')) {
            return view('admin.categories.partials.create-form')->render();
        }
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $category = Category::create($validated);

        $this->logAction('create_category', ['category_id' => $category->id, 'name' => $category->name]);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    public function show(Category $category)
    {
        $this->logAction('view_category_details', ['category_id' => $category->id]);
        return view('admin.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        if (request()->ajax() || request('ajax')) {
            return view('admin.categories.partials.edit-form', compact('category'))->render();
        }
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $category->update($validated);

        $this->logAction('update_category', ['category_id' => $category->id, 'changes' => $category->getChanges()]);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        if ($category->products()->exists()) {
            return back()->with('error', 'Cannot delete category with associated products.');
        }

        $category->delete();

        $this->logAction('delete_category', ['category_id' => $category->id, 'name' => $category->name]);

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }
}
