<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Purchase extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'date',
        'reference',
        'supplier_id',
        'supplier_name',
        'tax_percentage',
        'tax_amount',
        'discount_percentage',
        'discount_amount',
        'shipping_amount',
        'total_amount',
        'paid_amount',
        'due_amount',
        'status',
        'payment_status',
        'payment_method',
        'note',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'date' => 'date',
        'tax_percentage' => 'float',
        'discount_percentage' => 'float',
        'total_amount' => 'float',
        'paid_amount' => 'float',
        'due_amount' => 'float',
    ];

    /**
     * Get the supplier that placed the purchase.
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class); // ধরে নেওয়া হচ্ছে Supplier মডেল আছে
    }

    /**
     * Get the items/products associated with the purchase.
     * এটি কাজ করার জন্য আপনাকে 'purchase_items' বা 'purchase_details' টেবিল তৈরি করতে হবে।
     */
    public function purchaseItems(): HasMany
    {
        return $this->hasMany(PurchaseItem::class);
    }
}
