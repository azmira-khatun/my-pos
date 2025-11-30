<?php

namespace App\Http\Controllers;

use App\Models\Adjustment;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AdjustmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $adjustments = Adjustment::latest()->paginate(10);
        return view('pages.adjustments.index', compact('adjustments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('pages.adjustments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'date' => 'required|date',
            'reference' => 'required|string|max:191|unique:adjustments,reference',
            'note' => 'nullable|string',
        ]);

        Adjustment::create($request->all());

        return redirect()->route('adjustments.index')
                         ->with('success', 'Adjustment record successfully created. Now add products to it.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Adjustment $adjustment): View
    {
        // পণ্যের তালিকা লোড করুন যা এই অ্যাডজাস্টমেন্টের অংশ
        $adjustment->load('adjustedProducts.product');
        return view('pages.adjustments.show', compact('adjustment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Adjustment $adjustment): View
    {
        return view('pages.adjustments.edit', compact('adjustment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Adjustment $adjustment): RedirectResponse
    {
        $request->validate([
            'date' => 'required|date',
            // আপডেটের সময় নিজের রেফারেন্স বাদে অন্য রেফারেন্স unique চেক করার জন্য
            'reference' => 'required|string|max:191|unique:adjustments,reference,' . $adjustment->id,
            'note' => 'nullable|string',
        ]);

        $adjustment->update($request->all());

        return redirect()->route('adjustments.index')
                         ->with('success', 'Adjustment record successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     * Note: Deleting this will also delete associated 'adjusted_products' entries
     * due to 'onDelete('cascade')' in the migration. You might need to revert
     * the stock of those products here if they haven't been reverted already.
     */
    public function destroy(Adjustment $adjustment): RedirectResponse
    {
        // ⚠️ গুরুত্বপূর্ণ: এখানে স্টক রিভার্সালের লজিক যোগ করা উচিত
        // যদি adjusted_products মুছে ফেলার আগে স্টক পুনরুদ্ধার না হয়।

        $adjustment->delete();

        return redirect()->route('adjustments.index')
                         ->with('success', 'Adjustment record successfully deleted.');
    }
}
