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
        Schema::create('purchase_return_payments', function (Blueprint $table) {
            $table->id();

            // Foreign Key (Purchase Returns টেবিলকে রেফার করছে)
            $table->foreignId('purchase_return_id')
                  ->constrained('purchase_returns')
                  ->onDelete('cascade');

            $table->decimal('amount', 10, 2);  // সরবরাহকারী থেকে প্রাপ্ত রিফান্ড/ক্রেডিট অ্যামাউন্ট
            $table->date('date');

            // Reference (যেমন: সাপ্লাইয়ারের চেক নম্বর, ট্রানজেকশন আইডি)
            $table->string('reference', 191)->nullable();

            $table->string('payment_method'); // যেমন: Cash, Bank Transfer, Cheque
            $table->text('note')->nullable();

            $table->timestamps();

            $table->index('purchase_return_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_return_payments');
    }
};
