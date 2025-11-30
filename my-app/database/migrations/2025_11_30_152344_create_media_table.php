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
        Schema::create('media', function (Blueprint $table) {
            $table->id();

            // Polymorphic Relationship (model_type and model_id)
            $table->morphs('model'); // Creates model_id (unsignedBigInteger) and model_type (string)

            $table->uuid('uuid')->nullable()->unique(); // UUID (Unique Identifier)
            $table->string('collection_name');
            $table->string('name'); // Display name of the file
            $table->string('file_name'); // Actual filename stored on disk
            $table->string('mime_type')->nullable();
            $table->string('disk'); // Storage disk name (e.g., 'public', 's3')
            $table->string('conversions_disk')->nullable();
            $table->unsignedBigInteger('size'); // File size in bytes

            // JSON Fields for complex data
            $table->json('manipulations');
            $table->json('custom_properties');
            $table->json('generated_conversions');
            $table->json('responsive_images');

            $table->unsignedInteger('order_column')->nullable()->index();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
