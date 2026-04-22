<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Customers — identified by phone number only (no account required).
     */
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone', 30)->unique(); // Primary identifier — رقم الموبايل فقط
            $table->string('notes')->nullable();   // ملاحظات خاصة بالعميلة
            $table->unsignedSmallInteger('total_visits')->default(0);
            $table->timestamp('last_visit_at')->nullable();
            $table->timestamps();

            $table->index('phone');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
