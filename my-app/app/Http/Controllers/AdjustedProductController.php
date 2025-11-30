<?php

namespace App\Http\Controllers;

use App\Models\AdjustedProduct;
use App\Models\Product; // Product মডেল ব্যবহার করার জন্য
use App\Models\Adjustment; // Adjustment মডেল ব্যবহার করার জন্য
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB; // ট্রানজেকশনের জন্য

class AdjustedProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * সকল অ্যাডজাস্ট করা পণ্যের তালিকা প্রদর্শন করে।
     */
    public function index(): View
    {
        $adjustedProducts = AdjustedProduct::with(['adjustment', 'product'])->latest()->paginate(15);
        return view('pages.adjusted_products.index', compact('adjustedProducts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        // প্রয়োজনীয় ডেটা লোড করুন:
        $products = Product::pluck('product_name', 'id');
        // সাধারণত এটি Adjustment ID এর অধীনে তৈরি হয়, কিন্তু স্ট্যান্ডএলোন ফর্মের জন্য, যদি Adjustment টেবিল থাকে, তবে ID লোড করা যায়।
        $adjustments = Adjustment::pluck('id', 'id');

        return view('pages.adjusted_products.create', compact('products', 'adjustments'));
    }

    /**
     * Store a newly created resource in storage.
     * নতুন অ্যাডজাস্টমেন্ট এন্ট্রি সংরক্ষণ করে এবং স্টক আপডেট করে।
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'adjustment_id' => 'required|exists:adjustments,id',
            'product_id' => [
                'required',
                'exists:products,id',
                // নিশ্চিত করে যে একই অ্যাডজাস্টমেন্টে একই পণ্য একাধিকবার অ্যাডজাস্ট না হয়
                Rule::unique('adjusted_products')->where(fn ($query) =>
                    $query->where('adjustment_id', $request->adjustment_id)
                ),
            ],
            'quantity' => 'required|integer|min:1',
            'type' => 'required|in:Addition,Subtraction',
        ]);

        DB::beginTransaction();
        try {
            // 1. AdjustedProduct এন্ট্রি তৈরি করুন
            $adjustedProduct = AdjustedProduct::create($request->all());

            // 2. সংশ্লিষ্ট Product এর স্টক আপডেট করুন
            $product = Product::findOrFail($request->product_id);
            $quantityChange = $request->quantity;

            if ($request->type === 'Addition') {
                $product->increment('product_quantity', $quantityChange);
            } elseif ($request->type === 'Subtraction') {
                // বিয়োগের সময় যেন স্টক নেগেটিভ না হয় তা নিশ্চিত করুন (ঐচ্ছিক)
                if ($product->product_quantity < $quantityChange) {
                     DB::rollBack();
                     return back()->withInput()->withErrors(['quantity' => 'Quantity to subtract exceeds current stock.']);
                }
                $product->decrement('product_quantity', $quantityChange);
            }

            DB::commit();
            return redirect()->route('adjusted_products.index')
                             ->with('success', 'Product adjustment entry successfully created and stock updated.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error creating adjustment: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(AdjustedProduct $adjustedProduct): View
    {
        // with() ব্যবহার করে সম্পর্ক লোড করে যাতে N+1 সমস্যা না হয়
        $adjustedProduct->load('adjustment', 'product');
        return view('pages.adjusted_products.show', compact('adjustedProduct'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AdjustedProduct $adjustedProduct): View
    {
        // সম্পাদনার জন্য প্রয়োজনীয় ডেটা লোড করুন
        $products = Product::pluck('product_name', 'id');
        $adjustments = Adjustment::pluck('id', 'id');

        return view('pages.adjusted_products.edit', compact('adjustedProduct', 'products', 'adjustments'));
    }

    /**
     * Update the specified resource in storage.
     * অ্যাডজাস্টমেন্ট এন্ট্রি আপডেট করে এবং স্টকে পূর্বের পরিবর্তনটি সংশোধন করে।
     */
    public function update(Request $request, AdjustedProduct $adjustedProduct): RedirectResponse
    {
        $request->validate([
            'adjustment_id' => 'required|exists:adjustments,id',
            'product_id' => [
                'required',
                'exists:products,id',
                // আপডেটের সময় নিজের এন্ট্রি বাদে অন্যদের সাথে unique চেক করে
                Rule::unique('adjusted_products')->where(fn ($query) =>
                    $query->where('adjustment_id', $request->adjustment_id)
                )->ignore($adjustedProduct->id),
            ],
            'quantity' => 'required|integer|min:1',
            'type' => 'required|in:Addition,Subtraction',
        ]);

        DB::beginTransaction();
        try {
            $oldQuantity = $adjustedProduct->quantity;
            $oldType = $adjustedProduct->type;
            $product = Product::findOrFail($adjustedProduct->product_id);

            // 1. পূর্বের পরিবর্তনটি বাতিল করুন (স্টক পুনরুদ্ধার)
            if ($oldType === 'Addition') {
                $product->decrement('product_quantity', $oldQuantity);
            } else { // Subtraction
                $product->increment('product_quantity', $oldQuantity);
            }

            // 2. AdjustedProduct এন্ট্রি আপডেট করুন
            $adjustedProduct->update($request->all());
            $newQuantity = $adjustedProduct->quantity;
            $newType = $adjustedProduct->type;

            // 3. নতুন পরিবর্তনটি প্রয়োগ করুন (স্টক পুনরায় আপডেট)
            if ($newType === 'Addition') {
                $product->increment('product_quantity', $newQuantity);
            } else { // Subtraction
                 if ($product->product_quantity < $newQuantity) {
                     DB::rollBack();
                     return back()->withInput()->withErrors(['quantity' => 'Quantity to subtract exceeds current stock after reversal.']);
                }
                $product->decrement('product_quantity', $newQuantity);
            }

            DB::commit();
            return redirect()->route('adjusted_products.index')
                             ->with('success', 'Product adjustment entry successfully updated and stock revised.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error updating adjustment: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * অ্যাডজাস্টমেন্ট এন্ট্রি ডিলিট করে এবং স্টকে পরিবর্তনটিকে উল্টে দেয়।
     */
    public function destroy(AdjustedProduct $adjustedProduct): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $quantity = $adjustedProduct->quantity;
            $type = $adjustedProduct->type;
            $product = Product::findOrFail($adjustedProduct->product_id);

            // স্টকে পরিবর্তনটিকে উল্টে দিন (Revert the stock change)
            if ($type === 'Addition') {
                // যদি এটি যোগ করা হয়, তবে স্টক থেকে বিয়োগ করুন
                if ($product->product_quantity < $quantity) {
                     DB::rollBack();
                     return back()->with('error', 'Cannot delete: Reverting addition would lead to negative stock.');
                }
                $product->decrement('product_quantity', $quantity);
            } else { // Subtraction
                // যদি এটি বিয়োগ করা হয়, তবে স্টকে যোগ করুন
                $product->increment('product_quantity', $quantity);
            }

            // এন্ট্রি ডিলিট করুন
            $adjustedProduct->delete();

            DB::commit();
            return redirect()->route('adjusted_products.index')
                             ->with('success', 'Product adjustment entry successfully deleted and stock reverted.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error deleting adjustment: ' . $e->getMessage());
        }
    }
}
