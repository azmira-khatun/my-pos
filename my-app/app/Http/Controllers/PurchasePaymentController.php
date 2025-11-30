<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchasePayment;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class PurchasePaymentController extends Controller
{
    /**
     * Store a new payment record and update the parent Purchase model's status.
     */
    public function store(Request $request, Purchase $purchase): RedirectResponse
    {
        $validatedData = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'reference' => 'nullable|string|max:191',
            'payment_method' => 'required|string|max:191',
            'note' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // 1. Due Amount চেক করা
            if ($purchase->due_amount <= 0) {
                 DB::rollBack();
                 return back()->with('error', 'The purchase is already fully paid.');
            }

            $paymentAmount = $validatedData['amount'];

            // 2. Due Amount এর বেশি পেমেন্ট করা যাবে না
            if ($paymentAmount > $purchase->due_amount) {
                $paymentAmount = $purchase->due_amount;
            }

            // 3. PurchasePayment তৈরি করা
            $payment = $purchase->purchasePayments()->create(array_merge($validatedData, [
                'amount' => $paymentAmount,
                'purchase_id' => $purchase->id,
            ]));

            // 4. Purchase মডেল আপডেট করা
            $newPaidAmount = $purchase->paid_amount + $paymentAmount;
            $newDueAmount = $purchase->total_amount - $newPaidAmount;

            $paymentStatus = 'Partial';
            if ($newDueAmount <= 0) {
                $paymentStatus = 'Paid';
            } elseif ($newPaidAmount == 0) {
                 $paymentStatus = 'Pending';
            }

            $purchase->update([
                'paid_amount' => $newPaidAmount,
                'due_amount' => $newDueAmount,
                'payment_status' => $paymentStatus,
            ]);

            DB::commit();

            return back()->with('success', 'Payment of ' . number_format($paymentAmount, 2) . ' successfully recorded.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Payment transaction failed: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified payment record and revert the parent Purchase model's status.
     */
    public function destroy(PurchasePayment $purchasePayment): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $purchase = $purchasePayment->purchase;
            $amountToRevert = $purchasePayment->amount;

            // 1. Purchase মডেলের টাকা রিভার্ট করা
            $newPaidAmount = $purchase->paid_amount - $amountToRevert;
            $newDueAmount = $purchase->total_amount - $newPaidAmount;

            $paymentStatus = 'Partial';
            if ($newDueAmount <= 0) {
                $paymentStatus = 'Paid';
            } elseif ($newPaidAmount == 0) {
                 $paymentStatus = 'Pending';
            }

            $purchase->update([
                'paid_amount' => $newPaidAmount,
                'due_amount' => $newDueAmount,
                'payment_status' => $paymentStatus,
            ]);

            // 2. Payment এন্ট্রি ডিলিট করা
            $purchasePayment->delete();

            DB::commit();

            return back()->with('success', 'Payment successfully deleted and Purchase record reverted.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete payment: ' . $e->getMessage());
        }
    }
}
