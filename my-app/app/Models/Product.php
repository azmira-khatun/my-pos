<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id',
        'product_name',
        'product_code',
        'product_barcode_symbology',
        'product_quantity',
        'product_cost',
        'product_price',
        'product_unit',
        'product_stock_alert',
        'product_order_tax',
        'product_tax_type',
        'product_note',
    ];

    /**
     * Get the category that owns the Product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
