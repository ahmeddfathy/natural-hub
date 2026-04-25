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
        Schema::table('blogs', function (Blueprint $table) {
            $table->index(['is_published', 'created_at'], 'blogs_published_created_at_idx');
            $table->index(['category_id', 'is_published'], 'blogs_category_published_idx');
            $table->index('published_at', 'blogs_published_at_idx');
        });

        Schema::table('blog_images', function (Blueprint $table) {
            $table->index(['blog_id', 'sort_order'], 'blog_images_blog_sort_idx');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->index('is_active', 'categories_is_active_idx');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropIndex('blogs_published_created_at_idx');
            $table->dropIndex('blogs_category_published_idx');
            $table->dropIndex('blogs_published_at_idx');
        });

        Schema::table('blog_images', function (Blueprint $table) {
            $table->dropIndex('blog_images_blog_sort_idx');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex('categories_is_active_idx');
        });

    }
};
