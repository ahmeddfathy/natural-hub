<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Branches — the 3 salon locations.
     */
    public function up(): void
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('name');                               // اسم الفرع
            $table->string('address');                           // العنوان التفصيلي
            $table->string('city', 100)->default('الإسكندرية');
            $table->string('phone', 30)->nullable();
            $table->string('whatsapp', 30)->nullable();
            $table->string('google_maps_url')->nullable();
            $table->string('iframe_url')->nullable();            // للخريطة في صفحة الاتصال
            $table->time('opens_at')->default('10:00:00');
            $table->time('closes_at')->default('22:00:00');
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
