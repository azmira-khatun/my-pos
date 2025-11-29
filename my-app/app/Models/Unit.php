<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    // Mass assignment এর জন্য কলামগুলি সংজ্ঞায়িত করা হলো
    protected $fillable = [
        'name',
        'short_name',
        'operator',
        'operation_value',
    ];
}
