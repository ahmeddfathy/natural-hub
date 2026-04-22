<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category_type',
        'service_id',
        'excerpt',
        'description',
        'youtube_url',
        'youtube_video_id',
        'video_provider',
        'is_portrait',
        'drive_file_id',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'is_featured',
        'is_published',
        'published_at',
        'field_id',
        'video_category_id',
        'sort_order',
    ];

    protected $casts = [
        'is_featured'  => 'boolean',
        'is_published' => 'boolean',
        'is_portrait'  => 'boolean',
        'published_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($video) {
            if (empty($video->slug)) {
                $video->slug = Str::slug($video->title);
            }
        });
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function category()
    {
        return $this->belongsTo(VideoCategory::class, 'video_category_id');
    }

    public function field()
    {
        return $this->belongsTo(Field::class);
    }

    public function getYoutubeThumbnailUrlAttribute(): string
    {
        if ($this->isDriveVideo()) {
            return 'https://drive.google.com/thumbnail?id=' . $this->drive_file_id . '&sz=w1920';
        }

        return 'https://img.youtube.com/vi/' . $this->youtube_video_id . '/maxresdefault.jpg';
    }

    public function getYoutubeEmbedUrlAttribute(): string
    {
        if ($this->isDriveVideo()) {
            // Use Drive preview embed — plays directly in iframe
            return 'https://drive.google.com/file/d/' . $this->drive_file_id . '/preview?rm=minimal';
        }

        return 'https://www.youtube.com/embed/' . $this->youtube_video_id . '?vq=hd1080&rel=0';
    }

    public function getThumbnailUrlAttribute(): string
    {
        return $this->youtube_thumbnail_url;
    }

    public function getEmbedUrlAttribute(): string
    {
        return $this->youtube_embed_url;
    }

    public function getDriveStreamUrlAttribute(): ?string
    {
        if (!$this->isDriveVideo()) {
            return null;
        }

        return 'https://drive.google.com/uc?export=download&id=' . $this->drive_file_id;
    }

    public function isDriveVideo(): bool
    {
        return $this->video_provider === 'drive' && !empty($this->drive_file_id);
    }

    public static function extractYoutubeVideoId(?string $url): ?string
    {
        if (!$url) {
            return null;
        }

        $url = trim($url);

        if (preg_match('/^[a-zA-Z0-9_-]{11}$/', $url)) {
            return $url;
        }

        $parts = parse_url($url);

        if (!$parts || empty($parts['host'])) {
            return null;
        }

        $host = strtolower($parts['host']);
        $path = trim($parts['path'] ?? '', '/');

        if (str_contains($host, 'youtu.be')) {
            $segments = explode('/', $path);
            return preg_match('/^[a-zA-Z0-9_-]{11}$/', $segments[0] ?? '') ? $segments[0] : null;
        }

        if (str_contains($host, 'youtube.com') || str_contains($host, 'youtube-nocookie.com')) {
            parse_str($parts['query'] ?? '', $query);

            if (!empty($query['v']) && preg_match('/^[a-zA-Z0-9_-]{11}$/', $query['v'])) {
                return $query['v'];
            }

            $segments = explode('/', $path);
            $key = $segments[0] ?? null;
            $candidate = $segments[1] ?? null;

            if (in_array($key, ['embed', 'shorts', 'live', 'v'], true) && preg_match('/^[a-zA-Z0-9_-]{11}$/', (string) $candidate)) {
                return $candidate;
            }
        }

        return null;
    }

    public static function extractGoogleDriveFileId(?string $url): ?string
    {
        if (!$url) {
            return null;
        }

        $url = trim($url);

        if (preg_match('/^[a-zA-Z0-9_-]{20,}$/', $url)) {
            return $url;
        }

        $parts = parse_url($url);

        if (!$parts || empty($parts['host'])) {
            return null;
        }

        $host = strtolower($parts['host']);

        if (!str_contains($host, 'drive.google.com')) {
            return null;
        }

        $path = trim($parts['path'] ?? '', '/');

        if (preg_match('#file/d/([a-zA-Z0-9_-]+)#', $path, $matches)) {
            return $matches[1];
        }

        if (preg_match('#(?:uc|open)$#', $path)) {
            parse_str($parts['query'] ?? '', $query);

            if (!empty($query['id']) && preg_match('/^[a-zA-Z0-9_-]{20,}$/', $query['id'])) {
                return $query['id'];
            }
        }

        return null;
    }
}
