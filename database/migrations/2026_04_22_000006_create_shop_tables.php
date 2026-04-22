<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Shop products & bundles — the aftercare store.
     */
    public function up(): void
    {
        Schema::create('shop_bundles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('color_variant', 50)->nullable(); // Pink | Green | etc.
            $table->unsignedInteger('price');                // بالجنيه المصري
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('shop_products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->unsignedInteger('price');
            $table->string('size_label', 50)->nullable();        // e.g. "١٠٠٠ مل"
            $table->foreignId('bundle_id')->nullable()->constrained('shop_bundles')->nullOnDelete();
            $table->boolean('in_stock')->default(true);
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shop_products');
        Schema::dropIfExists('shop_bundles');
    }
};
