<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseCategory; // Category মডেল ইনক্লুড করা হলো
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Category এর সাথে লোড করা হলো
        $expenses = Expense::with('category')->latest()->get();
        return view('pages.expenses.index', compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ExpenseCategory::all(); // ক্যাটেগরি ড্রপডাউনের জন্য
        return view('pages.expenses.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'category_id' => 'required|exists:expense_categories,id',
            'date' => 'required|date',
            'reference' => 'nullable|string|max:50',
            'details' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
        ]);

        Expense::create($validatedData);

        return redirect()->route('expenses.index')
                         ->with('success', 'Expense recorded successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        $categories = ExpenseCategory::all(); // ক্যাটেগরি ড্রপডাউনের জন্য
        return view('pages.expenses.edit', compact('expense', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        $validatedData = $request->validate([
            'category_id' => 'required|exists:expense_categories,id',
            'date' => 'required|date',
            'reference' => 'nullable|string|max:50',
            'details' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
        ]);

        $expense->update($validatedData);

        return redirect()->route('expenses.index')
                         ->with('success', 'Expense updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();

        return redirect()->route('expenses.index')
                         ->with('success', 'Expense deleted successfully.');
    }

    // show() মেথডটি প্রয়োজন হলে যোগ করতে পারেন।
    public function show(Expense $expense)
    {
        $expense->load('category');
        return view('pages.expenses.show', compact('expense'));
    }
}
