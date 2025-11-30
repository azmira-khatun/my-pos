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
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 191);
            $table->string('guard_name', 191)->default('web'); // সাধারণত 'web' বা 'api' থাকে
            $table->timestamps();

            // একই গার্ডের মধ্যে নাম ইউনিক হতে হবে
            $table->unique(['name', 'guard_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
