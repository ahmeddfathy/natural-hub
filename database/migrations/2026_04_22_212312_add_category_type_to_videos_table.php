<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            // ── إضافة الحقول الجديدة ─────────────────────────────────────
            $table->string('category_type')->nullable()->after('title')
                  ->comment('Hair | Skin | Lashes | General');

            $table->foreignId('service_id')->nullable()->constrained('services')->nullOnDelete()
                  ->after('category_type');

            // Keep legacy video categories optional while videos move to category_type/service_id.
            $table->unsignedBigInteger('video_category_id')->nullable()->change();

            // ── نقل البيانات الموجودة: category_type = General مؤقتاً ──────
        });

        // تعيين قيمة افتراضية للفيديوهات الموجودة
        DB::table('videos')->whereNull('category_type')->update(['category_type' => 'General']);
    }

    public function down(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->dropForeign(['service_id']);
            $table->dropColumn(['category_type', 'service_id']);
        });
    }
};
