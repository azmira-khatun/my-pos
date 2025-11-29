<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{
    use HasFactory;

    // ম্যানুয়ালি টেবিলের নাম সংজ্ঞায়িত করা হলো, কারণ এটি বহুবচনে 'expense_categories'
    protected $table = 'expense_categories';

    // Mass assignment এর জন্য কলামগুলি সংজ্ঞায়িত করা হলো
    protected $fillable = [
        'category_name',
        'category_description',
    ];
}
