<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    // settings টেবিল যেহেতু, এটি একবারেই সব কলাম আপডেট করার জন্য
    protected $fillable = [
        'company_name',
        'company_email',
        'company_phone',
        'site_logo',
        'default_currency_id',
        'default_currency_position',
        'notification_email',
        'footer_text',
        'company_address',
    ];

    // default_currency_id এর সাথে রিলেশনশিপ
    public function defaultCurrency()
    {
        return $this->belongsTo(Currency::class, 'default_currency_id');
    }

    // যেহেতু একটি রো থাকবে, এটি ধরে নেওয়ার জন্য একটি স্ট্যাটিক মেথড
    public static function getSettings()
    {
        return self::firstOrCreate(['id' => 1]);
    }
}
