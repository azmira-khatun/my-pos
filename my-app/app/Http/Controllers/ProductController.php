<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category; // Category মডেল দরকার হবে
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $products = Product::latest()->paginate(10);
        return view('pages.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        // ক্যাটেগরি ড্রপডাউনের জন্য
        $categories = Category::pluck('category_name', 'id');
        return view('pages.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'product_name' => 'required|string|max:191|unique:products,product_name',
            'product_code' => 'required|string|max:191|unique:products,product_code',
            'product_quantity' => 'required|integer|min:0',
            'product_cost' => 'required|numeric|min:0',
            'product_price' => 'required|numeric|min:0',
            'product_unit' => 'nullable|string|max:50',
            'product_stock_alert' => 'nullable|integer|min:0',
            'product_order_tax' => 'nullable|numeric|min:0',
            'product_tax_type' => 'nullable|string|in:Exclusive,Inclusive',
            // অন্যান্য ফিল্ডের ভ্যালিডেশন...
        ]);

        Product::create($request->all());

        return redirect()->route('products.index')
                         ->with('success', 'Product successfully created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): View
    {
        return view('pages.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): View
    {
        $categories = Category::pluck('category_name', 'id');
        return view('pages.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            // ইউনিক ফিল্ড আপডেট করার জন্য
            'product_name' => [
                'required',
                'string',
                'max:191',
                Rule::unique('products')->ignore($product->id),
            ],
            'product_code' => [
                'required',
                'string',
                'max:191',
                Rule::unique('products')->ignore($product->id),
            ],
            'product_quantity' => 'required|integer|min:0',
            'product_cost' => 'required|numeric|min:0',
            'product_price' => 'required|numeric|min:0',
            // অন্যান্য ফিল্ডের ভ্যালিডেশন...
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')
                         ->with('success', 'Product successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('products.index')
                         ->with('success', 'Product successfully deleted.');
    }
}
