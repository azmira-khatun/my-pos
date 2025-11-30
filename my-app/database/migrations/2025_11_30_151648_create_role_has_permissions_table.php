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
        Schema::create('role_has_permissions', function (Blueprint $table) {
            // এই টেবিলের জন্য সাধারণত id() কলামের দরকার হয় না,
            // কারণ দুটি ফরেন কী-এর কম্বিনেশনই ইউনিক হিসেবে কাজ করে।
            // $table->id();

            // Foreign Key 1: permission_id
            $table->foreignId('permission_id')
                  ->constrained('permissions') // 'permissions' টেবিলকে রেফার করছে
                  ->onDelete('cascade');

            // Foreign Key 2: role_id
            $table->foreignId('role_id')
                  ->constrained('roles') // 'roles' টেবিলকে রেফার করছে (ধরে নিচ্ছি এটি আছে)
                  ->onDelete('cascade');

            // একই রোল যেন একই পারমিশন একাধিকবার না পায় তার জন্য ইউনিক কম্বিনেশন
            $table->primary(['permission_id', 'role_id']);

            // এই পিভট টেবিলের জন্য created_at ও updated_at সাধারণত দরকার হয় না
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_has_permissions');
    }
};
