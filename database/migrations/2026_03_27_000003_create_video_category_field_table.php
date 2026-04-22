<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('video_category_field', function (Blueprint $table) {
            $table->id();
            $table->foreignId('video_category_id')->constrained('video_categories')->cascadeOnDelete();
            $table->foreignId('field_id')->constrained('fields')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['video_category_id', 'field_id'], 'video_category_field_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('video_category_field');
    }
};
