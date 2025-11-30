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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();

            // Core Details
            $table->date('date');
            $table->string('reference', 191)->unique();

            // Supplier Relationship
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade');
            $table->string('supplier_name'); // Redundant but useful for reports if supplier is deleted

            // Taxes and Discounts
            $table->decimal('tax_percentage', 5, 2)->default(0.00);
            $table->decimal('tax_amount', 10, 2)->default(0.00);
            $table->decimal('discount_percentage', 5, 2)->default(0.00);
            $table->decimal('discount_amount', 10, 2)->default(0.00);
            $table->decimal('shipping_amount', 10, 2)->default(0.00);

            // Financial Totals
            $table->decimal('total_amount', 10, 2);
            $table->decimal('paid_amount', 10, 2)->default(0.00);
            $table->decimal('due_amount', 10, 2);

            // Statuses and Payment
            $table->enum('status', ['Pending', 'Completed', 'Cancelled'])->default('Pending');
            $table->enum('payment_status', ['Pending', 'Partial', 'Paid'])->default('Pending');
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
        Schema::dropIfExists('purchases');
    }
};
