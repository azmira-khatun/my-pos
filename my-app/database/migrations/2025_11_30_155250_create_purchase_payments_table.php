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
        Schema::create('purchase_payments', function (Blueprint $table) {
            $table->id();

            // Foreign Key (Purchases টেবিলকে রেফার করছে)
            $table->foreignId('purchase_id')
                  ->constrained('purchases')
                  ->onDelete('cascade');

            $table->decimal('amount', 10, 2);
            $table->date('date');

            // Reference (যেমন: চেক নম্বর, ট্রানজেকশন আইডি)
            $table->string('reference', 191)->nullable();

            $table->string('payment_method'); // যেমন: Cash, Bank Transfer, Cheque
            $table->text('note')->nullable();

            $table->timestamps();

            // দ্রুত খোঁজার জন্য একটি ইনডেক্স তৈরি করা হলো
            $table->index('purchase_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_payments');
    }
};
