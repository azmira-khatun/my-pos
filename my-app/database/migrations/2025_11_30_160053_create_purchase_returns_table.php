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
        Schema::create('purchase_returns', function (Blueprint $table) {
            $table->id();

            // Core Details
            $table->date('date');
            // Reference: একটি ইউনিক রেফারেন্স নম্বর (যেমন: PRF-0001)
            $table->string('reference', 191)->unique();

            // Supplier Relationship
            // Supplier ID: কোন সরবরাহকারীকে ফেরত দেওয়া হচ্ছে
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade');
            $table->string('supplier_name');

            // Taxes and Discounts (যদি ফেরতের সময় এগুলি হিসাব করা হয়)
            $table->decimal('tax_percentage', 5, 2)->default(0.00);
            $table->decimal('tax_amount', 10, 2)->default(0.00);
            $table->decimal('discount_percentage', 5, 2)->default(0.00);
            $table->decimal('discount_amount', 10, 2)->default(0.00);
            $table->decimal('shipping_amount', 10, 2)->default(0.00); // যদি রিটার্নের শিপিং কস্ট থাকে

            // Financial Totals
            $table->decimal('total_amount', 10, 2); // ফেরত দেওয়া পণ্যের মোট মূল্য
            $table->decimal('paid_amount', 10, 2)->default(0.00); // সরবরাহকারী যদি টাকা ফেরত দেয়
            $table->decimal('due_amount', 10, 2); // সরবরাহকারীর কাছ থেকে যে টাকা পাওনা আছে (ক্রেডিট)

            // Statuses and Payment Status (যেমন: ফেরত প্রক্রিয়া চলছে বা সম্পন্ন হয়েছে)
            $table->enum('status', ['Pending', 'Completed', 'Cancelled'])->default('Pending');
            // Payment Status: সরবরাহকারী টাকা ফেরত দিয়েছে কিনা (Pending Refund, Refunded)
            $table->enum('payment_status', ['Pending', 'Refunded', 'Credit'])->default('Credit');
            $table->string('payment_method')->nullable();

            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_returns');
    }
};
