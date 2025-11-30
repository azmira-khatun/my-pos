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
        Schema::create('purchase_return_details', function (Blueprint $table) {
            $table->id();

            // Foreign Keys
            $table->foreignId('purchase_return_id')
                  ->constrained('purchase_returns')
                  ->onDelete('cascade'); // যদি প্রধান রিটার্ন ডিলিট হয়, তবে ডিটেইলসও ডিলিট হবে

            $table->foreignId('product_id')
                  ->constrained('products')
                  ->onDelete('cascade');

            // Product Snapshot
            $table->string('product_name', 191);
            $table->string('product_code', 191);

            // Core Item Details
            $table->integer('quantity');           // ফেরত দেওয়া পণ্যের পরিমাণ
            $table->decimal('price', 10, 2);       // প্রতি পিসের আসল ক্রয় মূল্য
            $table->decimal('unit_price', 10, 2);  // ফেরত দেওয়ার সময় চূড়ান্ত ইউনিট মূল্য (কর/ছাড়ের পরে)
            $table->decimal('sub_total', 10, 2);   // (quantity * unit_price)

            // Tax and Discount per Item
            $table->decimal('product_discount_amount', 10, 2)->default(0.00);
            $table->enum('product_discount_type', ['Fixed', 'Percentage'])->nullable();
            $table->decimal('product_tax_amount', 10, 2)->default(0.00);

            $table->timestamps();

            // একই রিটার্নের মধ্যে একটি পণ্য একবারই থাকতে পারে
            $table->unique(['purchase_return_id', 'product_id'], 'pr_item_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_return_details');
    }
};
