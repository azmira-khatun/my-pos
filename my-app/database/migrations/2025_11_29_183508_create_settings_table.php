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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();

            $table->string('company_name')->nullable();
            $table->string('company_email')->nullable();
            $table->string('company_phone', 20)->nullable();
            $table->string('site_logo')->nullable(); // লোগোর ফাইলের নাম

            // Foreign Key to currencies table
            // ধরে নিলাম currency টেবিল আছে এবং default কারেন্সি সেট করতে
            $table->foreignId('default_currency_id')->nullable()->constrained('currencies')->onDelete('set null');

            $table->enum('default_currency_position', ['prefix', 'suffix'])->default('prefix'); // প্রতীক আগে ($100) নাকি পরে (100$)
            $table->string('notification_email')->nullable();
            $table->string('footer_text')->nullable();
            $table->text('company_address')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
