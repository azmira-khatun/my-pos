<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    // Mass assignment এর জন্য কলামগুলি সংজ্ঞায়িত করা হলো
    protected $fillable = [
        'currency_name',
        'code',
        'symbol',
        'thousand_separator',
        'decimal_separator',
        'exchange_rate',
    ];
}
