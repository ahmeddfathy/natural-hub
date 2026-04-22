<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->string('youtube_video_id', 32)->nullable()->change();
        });
    }

    public function down(): void
    {
        DB::table('videos')
            ->whereNull('youtube_video_id')
            ->update(['youtube_video_id' => '']);

        Schema::table('videos', function (Blueprint $table) {
            $table->string('youtube_video_id', 32)->nullable(false)->change();
        });
    }
};
