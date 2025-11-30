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
        Schema::create('purchase_details', function (Blueprint $table) {
            $table->id();

            // Foreign Keys (Purchases এবং Products টেবিলকে রেফার করছে)
            $table->foreignId('purchase_id')
                  ->constrained('purchases')
                  ->onDelete('cascade');

            $table->foreignId('product_id')
                  ->constrained('products')
                  ->onDelete('cascade');

            // Product Snapshot (যদি মূল product মুছে যায়, তবুও নাম জানা যাবে)
            $table->string('product_name', 191);
            $table->string('product_code', 191);

            // Core Item Details
            $table->integer('quantity');
            $table->decimal('price', 10, 2);       // প্রতি পিসের দাম (কর/ছাড় ছাড়া)
            $table->decimal('unit_price', 10, 2);  // চূড়ান্ত ইউনিট প্রাইস (কর/ছাড়ের পরে)
            $table->decimal('sub_total', 10, 2);   // (quantity * unit_price)

            // Tax and Discount per Item
            $table->decimal('product_discount_amount', 10, 2)->default(0.00);
            $table->enum('product_discount_type', ['Fixed', 'Percentage'])->nullable();
            $table->decimal('product_tax_amount', 10, 2)->default(0.00);

            $table->timestamps();

            // একই ক্রয়ের মধ্যে একটি পণ্য একবারই থাকতে পারে
            $table->unique(['purchase_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_details');
    }
};
