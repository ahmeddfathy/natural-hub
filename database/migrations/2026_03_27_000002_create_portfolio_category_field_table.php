<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolio_category_field', function (Blueprint $table) {
            $table->id();
            $table->foreignId('portfolio_category_id')->constrained('portfolio_categories')->cascadeOnDelete();
            $table->foreignId('field_id')->constrained('fields')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['portfolio_category_id', 'field_id'], 'portfolio_category_field_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio_category_field');
    }
};
