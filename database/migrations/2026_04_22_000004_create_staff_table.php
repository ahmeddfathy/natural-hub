<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Staff — salon employees assigned to branches and bookings.
     */
    public function up(): void
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->string('specialty', 100)->nullable(); // Hair | Skin | Lashes | All
            $table->string('phone', 30)->nullable();
            $table->string('avatar')->nullable();         // صورة الموظفة
            $table->enum('status', ['active', 'inactive', 'on_leave'])->default('active');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['branch_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
