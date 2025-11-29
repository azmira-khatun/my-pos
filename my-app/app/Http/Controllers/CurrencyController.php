<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currencies = Currency::all();
        return view('pages.currencies.index', compact('currencies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'currency_name' => 'required|string|max:255|unique:currencies,currency_name',
            'code' => 'required|string|max:10|unique:currencies,code',
            'symbol' => 'required|string|max:10',
            'exchange_rate' => 'required|numeric',
        ]);

        Currency::create($validatedData);

        return redirect()->route('currencies.index')
                         ->with('success', 'Currency created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Currency $currency)
    {
        return view('pages.currencies.show', compact('currency'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Currency $currency)
    {
        $validatedData = $request->validate([
            'currency_name' => 'required|string|max:255|unique:currencies,currency_name,' . $currency->id,
            'code' => 'required|string|max:10|unique:currencies,code,' . $currency->id,
            'symbol' => 'required|string|max:10',
            'exchange_rate' => 'required|numeric',
        ]);

        $currency->update($validatedData);

        return redirect()->route('currencies.index')
                         ->with('success', 'Currency updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Currency $currency)
    {
        $currency->delete();

        return redirect()->route('currencies.index')
                         ->with('success', 'Currency deleted successfully.');
    }

    // create() এবং edit() মেথডগুলি ফর্ম দেখানোর জন্য
    public function create() { return view('pages.currencies.create'); }
    public function edit(Currency $currency) { return view('pages.currencies.edit', compact('currency')); }
}
