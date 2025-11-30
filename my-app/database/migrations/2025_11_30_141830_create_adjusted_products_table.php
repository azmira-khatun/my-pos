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
        Schema::create('adjusted_products', function (Blueprint $table) {
            $table->id();

            // Foreign Keys (Relationship)
            $table->foreignId('adjustment_id') // Adjustment টেবিল থেকে
                  ->constrained('adjustments')
                  ->onDelete('cascade');

            $table->foreignId('product_id') // Product টেবিল থেকে
                  ->constrained('products')
                  ->onDelete('cascade');

            // Pivot Data
            $table->integer('quantity')->default(0); // পরিবর্তন হওয়া পরিমাণের সংখ্যা
            $table->enum('type', ['Addition', 'Subtraction']); // স্টক বাড়লো নাকি কমলো

            $table->timestamps();

            // Optionally, ensure the combination of adjustment_id and product_id is unique
            $table->unique(['adjustment_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adjusted_products');
    }
};
