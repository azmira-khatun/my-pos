<?php

namespace App\Http\Controllers;

use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class PurchaseReturnItemController extends Controller
{
    /**
     * Store a newly created return item in storage and update stock (decrement).
     */
    public function store(Request $request, PurchaseReturn $purchaseReturn): RedirectResponse
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
            $returnQuantity = $validatedData['quantity'];

            // ⚠️ স্টক চেক: নিশ্চিত করা যে স্টকে যথেষ্ট পণ্য আছে
            if ($product->product_quantity < $returnQuantity) {
                 DB::rollBack();
                 return back()->with('error', 'Insufficient stock to process the return.');
            }

            // 1. PurchaseReturnDetail তৈরি করা
            $detail = $purchaseReturn->returnItems()->create(array_merge($validatedData, [
                'product_name' => $product->product_name,
                'product_code' => $product->product_code,
            ]));

            // 2. Inventory আপডেট করা (স্টক কমানো)
            $product->decrement('product_quantity', $returnQuantity);

            // 3. PurchaseReturn-এর total_amount আপডেট করা
            $purchaseReturn->increment('total_amount', $detail->sub_total);
            // Due Amount (Supplier Credit) আপডেটের লজিক এখানে যুক্ত হবে...

            DB::commit();

            return back()->with('success', 'Product added to return successfully and stock decremented.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to add return item: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified return item from storage and revert stock (increment).
     */
    public function destroy(PurchaseReturnDetail $purchaseReturnDetail): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $product = Product::findOrFail($purchaseReturnDetail->product_id);
            $quantity = $purchaseReturnDetail->quantity;
            $subTotal = $purchaseReturnDetail->sub_total;

            // 1. Inventory তে স্টক পুনরায় যোগ করা
            $product->increment('product_quantity', $quantity);

            // 2. PurchaseReturn-এর total_amount আপডেট করা
            $purchaseReturn = $purchaseReturnDetail->purchaseReturn;
            $purchaseReturn->decrement('total_amount', $subTotal);
            // Due Amount (Supplier Credit) আপডেটের লজিক এখানে যুক্ত হবে...

            // 3. PurchaseReturnDetail এন্ট্রি ডিলিট করা
            $purchaseReturnDetail->delete();

            DB::commit();

            return back()->with('success', 'Return item deleted successfully and stock reverted.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete return item: ' . $e->getMessage());
        }
    }
}
