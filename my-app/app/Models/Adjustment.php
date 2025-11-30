<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Adjustment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'date',
        'reference',
        'note',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
    ];

    /**
     * Get the adjusted products for the adjustment.
     */
    public function adjustedProducts(): HasMany
    {
        // ধরে নেওয়া হচ্ছে আপনার AdjustedProduct মডেলটি আছে
        return $this->hasMany(AdjustedProduct::class);
    }
}
