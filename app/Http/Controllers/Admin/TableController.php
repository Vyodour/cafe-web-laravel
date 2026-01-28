<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Table;
use App\Traits\HasJsonLogging;
use Illuminate\Http\Request;

class TableController extends Controller
{
    use HasJsonLogging;

    public function index()
    {
        $this->logAction('view_tables_list');
        $tables = Table::orderBy('number')->paginate(10);
        return view('admin.tables.index', compact('tables'));
    }

    public function create()
    {
        if (request()->ajax() || request('ajax')) {
            return view('admin.tables.partials.create-form')->render();
        }
        return view('admin.tables.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'number' => 'required|integer|unique:tables,table_number', // Fixed column name in validation
            'status' => 'required|in:active,occupied,inactive', 
            'capacity' => 'required|integer|min:1',
        ]);

        $table = Table::create([
            'table_number' => $validated['number'],
            'status' => $validated['status'] == 'active' ? 'available' : $validated['status'], 
            'qr_code_token' => \Illuminate\Support\Str::random(32),
            'cafe_id' => \App\Models\Cafe::first()->id ?? 1,
            // 'capacity' => $validated['capacity'], // Removed as column doesn't exist in migration
        ]);
        
        $this->logAction('create_table', ['table_id' => $table->id, 'number' => $table->table_number]);

        return redirect()->route('admin.tables.index')->with('success', 'Table created successfully.');
    }

    public function show(Table $table)
    {
        $this->logAction('view_table_details', ['table_id' => $table->id]);
        return view('admin.tables.show', compact('table'));
    }

    public function edit(Table $table)
    {
        if (request()->ajax() || request('ajax')) {
            return view('admin.tables.partials.edit-form', compact('table'))->render();
        }
        return view('admin.tables.edit', compact('table'));
    }

    public function update(Request $request, Table $table)
    {
        $validated = $request->validate([
            'number' => 'required|integer|unique:tables,number,' . $table->id,
            'status' => 'required|in:active,inactive,occupied',
            'capacity' => 'required|integer|min:1',
        ]);

        $table->update($validated);

        $this->logAction('update_table', ['table_id' => $table->id, 'changes' => $table->getChanges()]);

        return redirect()->route('admin.tables.index')->with('success', 'Table updated successfully.');
    }

    public function destroy(Table $table)
    {
        $table->delete();

        $this->logAction('delete_table', ['table_id' => $table->id, 'number' => $table->number]);

        return redirect()->route('admin.tables.index')->with('success', 'Table deleted successfully.');
    }
}
