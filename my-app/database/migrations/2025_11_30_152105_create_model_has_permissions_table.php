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
        Schema::create('model_has_permissions', function (Blueprint $table) {

            // Foreign Key 1: permission_id
            $table->foreignId('permission_id')
                  ->constrained('permissions') // 'permissions' টেবিলকে রেফার করছে
                  ->onDelete('cascade');

            // Polymorphic Relationship: model_type এবং model_id
            // model_type: কোন মডেলের জন্য (যেমন, App\Models\User)
            // model_id: মডেলটির প্রাইমারি কী
            $table->string('model_type', 191);
            $table->unsignedBigInteger('model_id');

            // একটি নির্দিষ্ট মডেল (যেমন User) একটি পারমিশনের জন্য শুধুমাত্র একবারই ম্যাপ হবে
            $table->primary(['permission_id', 'model_id', 'model_type']);

            // Index তৈরি করা হলো যাতে query faster হয়
            $table->index(['model_id', 'model_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_has_permissions');
    }
};
