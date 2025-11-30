<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Supplier; // Supplier মডেল ব্যবহার করার জন্য
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB; // ট্রানজেকশনের জন্য

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $purchases = Purchase::with('supplier')->latest()->paginate(10);
        return view('pages.purchases.index', compact('purchases'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $suppliers = Supplier::pluck('supplier_name', 'id');
        return view('pages.purchases.create', compact('suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'date' => 'required|date',
            'reference' => 'required|string|max:191|unique:purchases,reference',
            'supplier_id' => 'required|exists:suppliers,id',
            // ... (অন্যান্য ফিল্ডের ভ্যালিডেশন)
            'total_amount' => 'required|numeric|min:0',
            'paid_amount' => 'required|numeric|lte:total_amount',
        ]);

        DB::beginTransaction();
        try {
            $supplier = Supplier::findOrFail($request->supplier_id);
            $validatedData['supplier_name'] = $supplier->supplier_name;
            $validatedData['due_amount'] = $validatedData['total_amount'] - $validatedData['paid_amount'];

            // payment_status সেট করা
            if ($validatedData['paid_amount'] >= $validatedData['total_amount']) {
                $validatedData['payment_status'] = 'Paid';
            } elseif ($validatedData['paid_amount'] > 0) {
                $validatedData['payment_status'] = 'Partial';
            } else {
                $validatedData['payment_status'] = 'Pending';
            }

            $purchase = Purchase::create($validatedData);

            // ⚠️ গুরুত্বপূর্ণ: এইখানে আপনাকে Purchase Items (পণ্যের তালিকা)
            // সেভ করার এবং Inventory (স্টক) আপডেট করার লজিক যোগ করতে হবে।

            DB::commit();

            return redirect()->route('purchases.show', $purchase->id)
                             ->with('success', 'Purchase record created successfully. Now add products.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Purchase creation failed: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase): View
    {
        // Purchase Items লোড করা
        $purchase->load('supplier', 'purchaseItems.product');
        return view('pages.purchases.show', compact('purchase'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $purchase): View
    {
        $suppliers = Supplier::pluck('supplier_name', 'id');
        return view('pages.purchases.edit', compact('purchase', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Purchase $purchase): RedirectResponse
    {
        $validatedData = $request->validate([
            'date' => 'required|date',
            'reference' => 'required|string|max:191|unique:purchases,reference,' . $purchase->id,
            'supplier_id' => 'required|exists:suppliers,id',
            // ... (অন্যান্য ফিল্ডের ভ্যালিডেশন)
            'total_amount' => 'required|numeric|min:0',
            'paid_amount' => 'required|numeric|lte:total_amount',
        ]);

        DB::beginTransaction();
        try {
            $supplier = Supplier::findOrFail($request->supplier_id);
            $validatedData['supplier_name'] = $supplier->supplier_name;
            $validatedData['due_amount'] = $validatedData['total_amount'] - $validatedData['paid_amount'];

            // payment_status আপডেট করা
            if ($validatedData['paid_amount'] >= $validatedData['total_amount']) {
                $validatedData['payment_status'] = 'Paid';
            } elseif ($validatedData['paid_amount'] > 0) {
                $validatedData['payment_status'] = 'Partial';
            } else {
                $validatedData['payment_status'] = 'Pending';
            }

            $purchase->update($validatedData);

            // ⚠️ গুরুত্বপূর্ণ: এইখানে আপনাকে Purchase Items এবং Inventory আপডেটের লজিক যোগ করতে হবে।

            DB::commit();

            return redirect()->route('purchases.index')
                             ->with('success', 'Purchase record successfully updated.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Purchase update failed: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase): RedirectResponse
    {
        DB::beginTransaction();
        try {
            // ⚠️ গুরুত্বপূর্ণ: এইখানে আপনাকে অবশ্যই Purchase Items ডিলিট করার আগে
            // Inventory থেকে স্টক কমিয়ে দেওয়ার লজিক যোগ করতে হবে।

            $purchase->delete();

            DB::commit();

            return redirect()->route('purchases.index')
                             ->with('success', 'Purchase record successfully deleted.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Purchase deletion failed: ' . $e->getMessage());
        }
    }
}
