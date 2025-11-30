<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchasePayment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'purchase_id',
        'amount',
        'date',
        'reference',
        'payment_method',
        'note',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'amount' => 'float',
        'date' => 'date',
    ];

    /**
     * Get the purchase order that the payment belongs to.
     */
    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class); // ধরে নেওয়া হচ্ছে Purchase মডেল আছে
    }
}
