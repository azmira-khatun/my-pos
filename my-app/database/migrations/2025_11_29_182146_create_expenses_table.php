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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id(); // id

            // Foreign Key to expense_categories table
            $table->foreignId('category_id')->constrained('expense_categories')->onDelete('cascade');

            $table->date('date'); // date
            $table->string('reference', 50)->nullable(); // reference (যেমন: Invoice ID)
            $table->text('details')->nullable(); // details
            $table->decimal('amount', 12, 2); // amount
            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
