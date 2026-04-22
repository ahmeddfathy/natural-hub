<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('portfolio_categories', function (Blueprint $table) {
            $table->foreignId('parent_id')
                ->nullable()
                ->after('slug')
                ->constrained('portfolio_categories')
                ->nullOnDelete();
        });

        Schema::table('video_categories', function (Blueprint $table) {
            $table->foreignId('parent_id')
                ->nullable()
                ->after('slug')
                ->constrained('video_categories')
                ->nullOnDelete();
        });

        Schema::table('blogs', function (Blueprint $table) {
            if (Schema::hasColumn('blogs', 'partner_id')) {
                $table->dropForeign(['partner_id']);
                $table->dropColumn('partner_id');
            }
        });

        Schema::table('portfolios', function (Blueprint $table) {
            if (Schema::hasColumn('portfolios', 'partner_id')) {
                $table->dropForeign(['partner_id']);
                $table->dropColumn('partner_id');
            }
        });

        Schema::table('videos', function (Blueprint $table) {
            if (Schema::hasColumn('videos', 'partner_id')) {
                $table->dropForeign(['partner_id']);
                $table->dropColumn('partner_id');
            }
        });

        Schema::dropIfExists('partners');
    }

    public function down(): void
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->nullable();
            $table->string('logo')->nullable();
            $table->string('website_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::table('blogs', function (Blueprint $table) {
            $table->foreignId('partner_id')->nullable()->after('category_id')->constrained()->nullOnDelete();
        });

        Schema::table('portfolios', function (Blueprint $table) {
            $table->foreignId('partner_id')->nullable()->after('portfolio_category_id')->constrained()->nullOnDelete();
        });

        Schema::table('videos', function (Blueprint $table) {
            $table->foreignId('partner_id')->nullable()->after('video_category_id')->constrained()->nullOnDelete();
        });

        Schema::table('portfolio_categories', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn('parent_id');
        });

        Schema::table('video_categories', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn('parent_id');
        });
    }
};
