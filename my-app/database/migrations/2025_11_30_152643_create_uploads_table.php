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
        Schema::create('uploads', function (Blueprint $table) {
            $table->id();

            // ফাইলটি কোন ফোল্ডারে সেভ হয়েছে (যেমন: 'user_photos', 'documents/invoices')
            $table->string('folder', 191)->nullable();

            // ডিস্কে সেভ করা ফাইলের আসল নাম (যেমন: 'unique_hash_123.jpg')
            $table->string('filename', 191);

            // যদি আপনি আপলোড করা ফাইলের আসল নাম সংরক্ষণ করতে চান:
            // $table->string('original_filename', 191)->nullable();

            $table->timestamps(); // created_at এবং updated_at

            // দ্রুত খোঁজার জন্য একটি সম্মিলিত ইনডেক্স তৈরি করা হলো
            $table->index(['folder', 'filename']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uploads');
    }
};
