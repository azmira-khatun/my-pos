<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class PurchaseItemController extends Controller
{
    // সাধারণত, এখানে index, show, create, edit মেথড প্রয়োজন নেই।
    // পুরো কাজটি PurchaseController-এর show/edit মেথডের মাধ্যমে Blade-এ করা হয়।

    /**
     * Store a newly created purchase item in storage and update stock.
     */
    public function store(Request $request, Purchase $purchase): RedirectResponse
    {
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            // ... (অন্যান্য ফিল্ডের ভ্যালিডেশন)
            'sub_total' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $product = Product::findOrFail($validatedData['product_id']);

            // 1. PurchaseDetail তৈরি করা
            $detail = $purchase->purchaseItems()->create(array_merge($validatedData, [
                'product_name' => $product->product_name,
                'product_code' => $product->product_code,
                // এখানে unit_price, tax_amount, discount_amount ইত্যাদি হিসাব করে দিতে হবে।
            ]));

            // 2. Inventory আপডেট করা
            $product->increment('product_quantity', $detail->quantity);

            // 3. Purchase-এর total_amount এবং payment_status আপডেট করা
            $purchase->increment('total_amount', $detail->sub_total);
            // Due Amount এবং Payment Status আপডেটের লজিক এখানে যুক্ত হবে...

            DB::commit();

            return back()->with('success', 'Product added to purchase successfully and stock updated.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to add item: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified purchase item from storage and revert stock.
     */
    public function destroy(PurchaseDetail $purchaseDetail): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $product = Product::findOrFail($purchaseDetail->product_id);
            $quantity = $purchaseDetail->quantity;
            $subTotal = $purchaseDetail->sub_total;

            // 1. Inventory থেকে স্টক কমানো
            if ($product->product_quantity < $quantity) {
                 DB::rollBack();
                 return back()->with('error', 'Cannot delete: Reverting purchase would lead to negative stock.');
            }
            $product->decrement('product_quantity', $quantity);

            // 2. Purchase-এর total_amount এবং payment_status আপডেট করা
            $purchase = $purchaseDetail->purchase;
            $purchase->decrement('total_amount', $subTotal);
            // Due Amount এবং Payment Status আপডেটের লজিক এখানে যুক্ত হবে...

            // 3. PurchaseDetail এন্ট্রি ডিলিট করা
            $purchaseDetail->delete();

            DB::commit();

            return back()->with('success', 'Item deleted successfully and stock reverted.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete item: ' . $e->getMessage());
        }
    }
}
