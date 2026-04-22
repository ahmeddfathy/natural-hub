<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            $table->foreignId('field_id')
                ->nullable()
                ->after('portfolio_category_id')
                ->constrained('fields')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            $table->dropConstrainedForeignId('field_id');
        });
    }
};
