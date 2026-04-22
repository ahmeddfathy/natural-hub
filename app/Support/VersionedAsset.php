<?php

namespace App\Support;

use Illuminate\Support\Facades\File;

class VersionedAsset
{
    /**
     * Memoize versions per request to avoid repeated filesystem lookups.
     *
     * @var array<string, string|null>
     */
    protected static array $versions = [];

    public static function url(string $path): string
    {
        $url = asset($path);
        $version = static::version($path);

        if (!$version) {
            return $url;
        }

        $separator = str_contains($url, '?') ? '&' : '?';

        return "{$url}{$separator}v={$version}";
    }

    protected static function version(string $path): ?string
    {
        if (array_key_exists($path, static::$versions)) {
            return static::$versions[$path];
        }

        $absolutePath = public_path($path);
        $mtime = File::exists($absolutePath) ? (string) File::lastModified($absolutePath) : null;
        $configuredVersion = config('app.asset_version');

        // In local env, auto-refresh assets when file changes.
        if (app()->environment('local')) {
            return static::$versions[$path] = $mtime ?? (string) $configuredVersion;
        }

        // In non-local env, prefer explicit deploy version, then fallback to mtime.
        return static::$versions[$path] = $configuredVersion ? (string) $configuredVersion : $mtime;
    }
}
