<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $suppliers = Supplier::latest()->paginate(10);
        return view('pages.suppliers.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('pages.suppliers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'supplier_name' => 'required|string|max:100',
            'supplier_email' => 'required|email|unique:suppliers|max:100',
            'supplier_phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:50',
            'country' => 'nullable|string|max:50',
            'address' => 'nullable|string',
        ]);

        Supplier::create($request->all());

        return redirect()->route('suppliers.index')
                         ->with('success', 'Supplier successfully created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier): View
    {
        return view('pages.suppliers.show', compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier): View
    {
        return view('pages.suppliers.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier): RedirectResponse
    {
        $request->validate([
            'supplier_name' => 'required|string|max:100',
            // Update এর সময় নিজের ইমেল বাদে অন্য ইমেল unique চেক করার জন্য
            'supplier_email' => 'required|email|unique:suppliers,supplier_email,' . $supplier->id . '|max:100',
            'supplier_phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:50',
            'country' => 'nullable|string|max:50',
            'address' => 'nullable|string',
        ]);

        $supplier->update($request->all());

        return redirect()->route('suppliers.index')
                         ->with('success', 'Supplier successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier): RedirectResponse
    {
        $supplier->delete();

        return redirect()->route('suppliers.index')
                         ->with('success', 'Supplier successfully deleted.');
    }
}
