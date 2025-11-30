<?php

namespace App\Http\Controllers;

use App\Models\PurchaseReturn;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class PurchaseReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $returns = PurchaseReturn::with('supplier')->latest()->paginate(10);
        return view('pages.purchase_returns.index', compact('returns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $suppliers = Supplier::pluck('supplier_name', 'id');
        return view('pages.purchase_returns.create', compact('suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'date' => 'required|date',
            'reference' => 'required|string|max:191|unique:purchase_returns,reference',
            'supplier_id' => 'required|exists:suppliers,id',
            // ... অন্যান্য ফিল্ড ভ্যালিডেশন
            'total_amount' => 'required|numeric|min:0',
            'paid_amount' => 'required|numeric|lte:total_amount',
        ]);

        DB::beginTransaction();
        try {
            $supplier = Supplier::findOrFail($request->supplier_id);
            $validatedData['supplier_name'] = $supplier->supplier_name;

            // Due Amount এখানে নির্দেশ করে সরবরাহকারীর কাছ থেকে কত টাকা পাওনা
            $validatedData['due_amount'] = $validatedData['total_amount'] - $validatedData['paid_amount'];

            // Payment Status এখানে রিফান্ডের অবস্থা নির্দেশ করে
            $validatedData['payment_status'] = ($validatedData['paid_amount'] > 0) ? 'Refunded' : 'Credit';

            $return = PurchaseReturn::create($validatedData);

            // ⚠️ গুরুত্বপূর্ণ: এইখানে আপনাকে Return Items সেভ করার এবং Inventory (স্টক)
            // কমানোর (বা রিভার্ট করার) লজিক যোগ করতে হবে।

            DB::commit();

            return redirect()->route('purchase_returns.show', $return->id)
                             ->with('success', 'Purchase Return created successfully. Now add products.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Purchase Return creation failed: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PurchaseReturn $purchaseReturn): View
    {
        // Return Items এবং Payments লোড করা
        $purchaseReturn->load('supplier', 'returnItems', 'returnPayments');
        return view('pages.purchase_returns.show', compact('purchaseReturn'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PurchaseReturn $purchaseReturn): View
    {
        $suppliers = Supplier::pluck('supplier_name', 'id');
        return view('pages.purchase_returns.edit', compact('purchaseReturn', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PurchaseReturn $purchaseReturn): RedirectResponse
    {
        $validatedData = $request->validate([
            'date' => 'required|date',
            'reference' => 'required|string|max:191|unique:purchase_returns,reference,' . $purchaseReturn->id,
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
            $validatedData['payment_status'] = ($validatedData['paid_amount'] > 0) ? 'Refunded' : 'Credit';

            $purchaseReturn->update($validatedData);

            // ⚠️ গুরুত্বপূর্ণ: এইখানে আপনাকে Return Items এবং Inventory আপডেটের লজিক যোগ করতে হবে।

            DB::commit();

            return redirect()->route('purchase_returns.index')
                             ->with('success', 'Purchase Return record successfully updated.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Purchase Return update failed: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchaseReturn $purchaseReturn): RedirectResponse
    {
        DB::beginTransaction();
        try {
            // ⚠️ গুরুত্বপূর্ণ: এইখানে আপনাকে Inventory তে স্টক পুনরায় যোগ করার লজিক যোগ করতে হবে।

            $purchaseReturn->delete();

            DB::commit();

            return redirect()->route('purchase_returns.index')
                             ->with('success', 'Purchase Return record successfully deleted.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Purchase Return deletion failed: ' . $e->getMessage());
        }
    }
}
