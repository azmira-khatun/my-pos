<?php

namespace App\Http\Controllers;

use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnPayment;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class PurchaseReturnPaymentController extends Controller
{
    /**
     * Store a new refund/credit record and update the parent PurchaseReturn model's status.
     */
    public function store(Request $request, PurchaseReturn $purchaseReturn): RedirectResponse
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
            // 1. Due Amount (Supplier Credit) চেক করা
            if ($purchaseReturn->due_amount <= 0) {
                 DB::rollBack();
                 return back()->with('error', 'The supplier has already refunded the full amount.');
            }

            $refundAmount = $validatedData['amount'];

            // 2. যে টাকা পাওনা, তার বেশি রিফান্ড রেকর্ড করা যাবে না
            if ($refundAmount > $purchaseReturn->due_amount) {
                $refundAmount = $purchaseReturn->due_amount;
            }

            // 3. PurchaseReturnPayment তৈরি করা
            $payment = $purchaseReturn->returnPayments()->create(array_merge($validatedData, [
                'amount' => $refundAmount,
                'purchase_return_id' => $purchaseReturn->id,
            ]));

            // 4. PurchaseReturn মডেল আপডেট করা
            $newPaidAmount = $purchaseReturn->paid_amount + $refundAmount;
            $newDueAmount = $purchaseReturn->total_amount - $newPaidAmount; // এখন Due Amount মানে পাওনা ক্রেডিট

            $paymentStatus = 'Credit'; // আংশিক ক্রেডিট বা রিফান্ড হয়েছে
            if ($newDueAmount <= 0) {
                $paymentStatus = 'Refunded'; // সম্পূর্ণ রিফান্ড হয়েছে
            } elseif ($newPaidAmount == 0) {
                 $paymentStatus = 'Credit'; // কোনো রিফান্ড হয়নি, সম্পূর্ণ ক্রেডিট পাওনা
            }

            $purchaseReturn->update([
                'paid_amount' => $newPaidAmount,
                'due_amount' => $newDueAmount,
                'payment_status' => $paymentStatus,
            ]);

            DB::commit();

            return back()->with('success', 'Refund of ' . number_format($refundAmount, 2) . ' successfully recorded from supplier.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Refund transaction failed: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified refund record and revert the parent PurchaseReturn model's status.
     */
    public function destroy(PurchaseReturnPayment $purchaseReturnPayment): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $purchaseReturn = $purchaseReturnPayment->purchaseReturn;
            $amountToRevert = $purchaseReturnPayment->amount;

            // 1. PurchaseReturn মডেলের টাকা রিভার্ট করা
            $newPaidAmount = $purchaseReturn->paid_amount - $amountToRevert;
            $newDueAmount = $purchaseReturn->total_amount - $newPaidAmount;

            $paymentStatus = 'Credit';
            if ($newDueAmount <= 0) {
                $paymentStatus = 'Refunded';
            } elseif ($newPaidAmount == 0) {
                 $paymentStatus = 'Credit';
            }

            $purchaseReturn->update([
                'paid_amount' => $newPaidAmount,
                'due_amount' => $newDueAmount,
                'payment_status' => $paymentStatus,
            ]);

            // 2. Payment এন্ট্রি ডিলিট করা
            $purchaseReturnPayment->delete();

            DB::commit();

            return back()->with('success', 'Refund record successfully deleted and Purchase Return record reverted.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete refund record: ' . $e->getMessage());
        }
    }
}
