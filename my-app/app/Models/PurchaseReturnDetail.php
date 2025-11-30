<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseReturnDetail extends Model
{
    use HasFactory;

    // টেবিল কনভেনশন
    protected $table = 'purchase_return_details';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'purchase_return_id',
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
     * Get the purchase return that owns the detail.
     */
    public function purchaseReturn(): BelongsTo
    {
        return $this->belongsTo(PurchaseReturn::class);
    }

    /**
     * Get the product associated with the detail.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
