<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('description')->nullable();
            $table->string('youtube_url', 500);
            $table->string('youtube_video_id', 32)->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('canonical_url')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->foreignId('video_category_id')->nullable()->constrained('video_categories')->nullOnDelete();
            $table->foreignId('partner_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();

            $table->index(['is_published', 'published_at'], 'videos_published_at_idx');
            $table->index(['video_category_id', 'is_published'], 'videos_category_published_idx');
            $table->index('youtube_video_id', 'videos_youtube_id_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
