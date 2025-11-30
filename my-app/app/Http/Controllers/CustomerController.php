<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\View\View; // View return করার জন্য
use Illuminate\Http\RedirectResponse; // Redirect return করার জন্য

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $customers = Customer::latest()->paginate(10);
        return view('pages.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('pages.customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'customer_name' => 'required|string|max:100',
            'customer_email' => 'required|email|unique:customers|max:100',
            'customer_phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:50',
            'country' => 'nullable|string|max:50',
            'address' => 'nullable|string',
        ]);

        Customer::create($request->all());

        return redirect()->route('customers.index')
                         ->with('success', 'Customer successfully created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer): View
    {
        return view('pages.customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer): View
    {
        return view('pages.customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer): RedirectResponse
    {
        $request->validate([
            'customer_name' => 'required|string|max:100',
            // Update এর সময় নিজের ইমেল বাদে অন্য ইমেল unique চেক করার জন্য
            'customer_email' => 'required|email|unique:customers,customer_email,' . $customer->id . '|max:100',
            'customer_phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:50',
            'country' => 'nullable|string|max:50',
            'address' => 'nullable|string',
        ]);

        $customer->update($request->all());

        return redirect()->route('customers.index')
                         ->with('success', 'Customer successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer): RedirectResponse
    {
        $customer->delete();

        return redirect()->route('customers.index')
                         ->with('success', 'Customer successfully deleted.');
    }
}
