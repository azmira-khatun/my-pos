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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // Foreign Key
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');

            // Product Details
            $table->string('product_name', 191)->unique();
            $table->string('product_code', 191)->unique();
            $table->string('product_barcode_symbology', 50)->nullable(); // যেমন: C128, EAN13
            $table->string('product_unit', 50)->nullable(); // যেমন: Pcs, Kg, Litre
            $table->text('product_note')->nullable();

            // Quantity & Pricing
            $table->integer('product_quantity')->default(0);
            $table->decimal('product_cost', 10, 2)->default(0.00); // কেনা দাম
            $table->decimal('product_price', 10, 2)->default(0.00); // বিক্রির দাম

            // Stock & Tax
            $table->integer('product_stock_alert')->default(10); // স্টক এলার্ট
            $table->decimal('product_order_tax', 8, 2)->nullable(); // অর্ডারের উপর ট্যাক্স (percentage)
            $table->string('product_tax_type', 20)->nullable(); // যেমন: Exclusive/Inclusive

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
