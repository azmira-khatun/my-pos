<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = ExpenseCategory::all();
        return view('pages.expense_categories.index', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'category_name' => 'required|string|max:255|unique:expense_categories,category_name',
            'category_description' => 'nullable|string',
        ]);

        ExpenseCategory::create($validatedData);

        return redirect()->route('expense_categories.index')
                         ->with('success', 'Expense Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ExpenseCategory $expenseCategory)
    {
        return view('pages.expense_categories.show', compact('expenseCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExpenseCategory $expenseCategory)
    {
        $validatedData = $request->validate([
            // আপডেটের সময় বর্তমান আইডি বাদ দিতে হবে
            'category_name' => 'required|string|max:255|unique:expense_categories,category_name,' . $expenseCategory->id,
            'category_description' => 'nullable|string',
        ]);

        $expenseCategory->update($validatedData);

        return redirect()->route('expense_categories.index')
                         ->with('success', 'Expense Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExpenseCategory $expenseCategory)
    {
        $expenseCategory->delete();

        return redirect()->route('expense_categories.index')
                         ->with('success', 'Expense Category deleted successfully.');
    }

    // create() এবং edit() মেথডগুলি ফর্ম দেখানোর জন্য
    public function create() { return view('pages.expense_categories.create'); }
    public function edit(ExpenseCategory $expenseCategory) { return view('pages.expense_categories.edit', compact('expenseCategory')); }
}
