<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseDetail extends Model
{
    use HasFactory;

    // টেবিল কনভেনশন যদি 'purchase_details' হয়
    protected $table = 'purchase_details';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'purchase_id',
        'product_id',
        'product_name',
        'product_code',
        'quantity',
        'price',
        'unit_price',
        'sub_total',
        'product_discount_amount',
        'product_discount_type',
        'product_tax_amount',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'quantity' => 'integer',
        'price' => 'float',
        'unit_price' => 'float',
        'sub_total' => 'float',
        'product_discount_amount' => 'float',
        'product_tax_amount' => 'float',
    ];

    /**
     * Get the purchase order that owns the detail.
     */
    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class); // ধরে নেওয়া হচ্ছে Purchase মডেল আছে
    }

    /**
     * Get the product associated with the detail.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class); // ধরে নেওয়া হচ্ছে Product মডেল আছে
    }
}
