<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Mass assignment এর জন্য কলামগুলি সংজ্ঞায়িত করা হলো
    protected $fillable = [
        'category_code',
        'category_name',
    ];

    /**
     * একটি ক্যাটেগরির অধীনে থাকা প্রোডাক্টগুলি পেতে নিচের রিলেশনটি ব্যবহার করা যেতে পারে।
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
