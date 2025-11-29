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
        Schema::create('units', function (Blueprint $table) {
            $table->id(); // id
            $table->string('name')->unique(); // name (যেমন: Kilogram)
            $table->string('short_name', 50)->nullable(); // short_name (যেমন: KG)
            $table->string('operator', 50)->nullable(); // operator (যেমন: *, /)
            $table->string('operation_value')->nullable(); // operation_value (যেমন: 1000, 12)
            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
