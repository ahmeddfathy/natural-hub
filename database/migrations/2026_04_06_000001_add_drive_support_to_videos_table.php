<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->string('video_provider', 20)
                ->default('youtube')
                ->after('youtube_video_id');
            $table->string('drive_file_id', 255)
                ->nullable()
                ->after('video_provider');

            $table->index('video_provider', 'videos_provider_idx');
            $table->index('drive_file_id', 'videos_drive_file_id_idx');
        });
    }

    public function down(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->dropIndex('videos_provider_idx');
            $table->dropIndex('videos_drive_file_id_idx');
            $table->dropColumn(['video_provider', 'drive_file_id']);
        });
    }
};
