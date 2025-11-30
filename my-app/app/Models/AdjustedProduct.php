<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdjustedProduct extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'adjustment_id',
        'product_id',
        'quantity',
        'type', // Addition or Subtraction
    ];

    /**
     * Get the adjustment that owns the AdjustedProduct.
     */
    public function adjustment(): BelongsTo
    {
        return $this->belongsTo(Adjustment::class);
    }

    /**
     * Get the product that was adjusted.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
