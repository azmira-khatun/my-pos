<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    // Mass assignment এর জন্য কলামগুলি সংজ্ঞায়িত করা হলো
    protected $fillable = [
        'category_id',
        'date',
        'reference',
        'details',
        'amount',
    ];

    // ডেট কলাম স্বয়ংক্রিয়ভাবে Carbon ইনস্ট্যান্সে রূপান্তর করতে
    protected $casts = [
        'date' => 'date',
    ];

    /**
     * ExpenseCategory মডেলের সাথে রিলেশনশিপ।
     */
    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class, 'category_id');
    }
}
