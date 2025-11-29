<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id(); // id
            $table->string('currency_name')->unique(); // currency_name (যেমন: Bangladeshi Taka)
            $table->string('code', 10)->unique(); // code (যেমন: BDT, USD)
            $table->string('symbol', 10); // symbol (যেমন: ৳, $)
            $table->string('thousand_separator', 5)->default(','); // thousand_separator (যেমন: ,)
            $table->string('decimal_separator', 5)->default('.'); // decimal_separator (যেমন: .)
            $table->decimal('exchange_rate', 12, 6)->default(1.00); // exchange_rate
            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
};
