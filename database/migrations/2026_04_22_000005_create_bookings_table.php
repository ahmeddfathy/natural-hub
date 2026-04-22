<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Bookings — core booking system supporting both website & manual entry channels.
     *
     * status:  pending (website) → confirmed → completed | cancelled
     * source:  website | manual
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            // Relations
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->foreignId('staff_id')->nullable()->constrained('staff')->nullOnDelete();

            // Booking details
            $table->dateTime('appointment_at');                               // موعد الجلسة
            $table->unsignedSmallInteger('duration_minutes')->nullable();     // مدة الجلسة (تُرث من الخدمة)
            $table->text('notes')->nullable();                                // ملاحظات العميلة

            // Status & source
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');
            $table->enum('source', ['website', 'manual'])->default('website');

            // Cancellation tracking
            $table->string('cancellation_reason')->nullable();
            $table->timestamp('cancelled_at')->nullable();

            $table->timestamps();

            // Indexes for dashboard queries
            $table->index(['branch_id', 'status']);
            $table->index(['branch_id', 'appointment_at']);
            $table->index(['staff_id', 'appointment_at']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
