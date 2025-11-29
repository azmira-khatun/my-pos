<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $units = Unit::all();
        return view('pages.units.index', compact('units'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation logic here
        $validatedData = $request->validate([
            'name' => 'required|unique:units',
            // Add other validation rules here
        ]);

        Unit::create($validatedData);

        return redirect()->route('units.index')
                         ->with('success', 'Unit created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $unit)
    {
        return view('pages.units.show', compact('unit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unit $unit)
    {
        // Validation logic here
        $validatedData = $request->validate([
            'name' => 'required|unique:units,name,' . $unit->id,
            // Add other validation rules here
        ]);

        $unit->update($validatedData);

        return redirect()->route('units.index')
                         ->with('success', 'Unit updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        $unit->delete();

        return redirect()->route('units.index')
                         ->with('success', 'Unit deleted successfully.');
    }

    // create() এবং edit() মেথডগুলি ফর্ম দেখানোর জন্য ব্যবহৃত হবে, প্রয়োজন অনুযায়ী যোগ করুন।
    public function create() { return view('pages.units.create'); }
    public function edit(Unit $unit) { return view('pages.units.edit', compact('unit')); }
}
