<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add price, duration, category_type & branch_id to the existing services table.
     * category_type: Hair | Skin | Lashes | Shop
     */
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->string('category_type', 50)->default('Hair')->after('title');
            $table->string('price_label', 100)->nullable()->after('category_type'); // e.g. "يبدأ من ٦٠٠ ج"
            $table->unsignedSmallInteger('price_min')->nullable()->after('price_label');
            $table->unsignedSmallInteger('price_max')->nullable()->after('price_min');
            $table->unsignedSmallInteger('duration_minutes')->nullable()->after('price_max');
            $table->string('icon', 100)->nullable()->after('duration_minutes'); // FontAwesome class
            $table->unsignedBigInteger('branch_id')->nullable()->after('icon');

            // Index for fast filtering
            $table->index('category_type');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropIndex(['category_type']);
            $table->dropIndex(['is_active']);
            $table->dropColumn([
                'category_type', 'price_label', 'price_min', 'price_max',
                'duration_minutes', 'icon', 'branch_id',
            ]);
        });
    }
};
