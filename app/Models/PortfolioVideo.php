<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortfolioVideo extends Model
{
    protected $fillable = [
        'portfolio_id',
        'title',
        'url',
        'video_provider',
        'youtube_video_id',
        'drive_file_id',
        'sort_order',
    ];

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }

    public function getThumbnailUrlAttribute(): string
    {
        if ($this->video_provider === 'drive' && $this->drive_file_id) {
            return 'https://drive.google.com/thumbnail?id=' . $this->drive_file_id . '&sz=w1920';
        }
        return 'https://img.youtube.com/vi/' . $this->youtube_video_id . '/maxresdefault.jpg';
    }

    public function getEmbedUrlAttribute(): string
    {
        if ($this->video_provider === 'drive' && $this->drive_file_id) {
            return 'https://drive.google.com/file/d/' . $this->drive_file_id . '/preview';
        }
        return 'https://www.youtube.com/embed/' . $this->youtube_video_id;
    }
}
