@php echo '<?xml version="1.0" encoding="UTF-8"?>'; @endphp
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
        xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">

{{-- ── Static + Blog pages ───────────────────────────────────────────── --}}
@foreach($urls as $url)
    <url>
        <loc>{{ $url['url'] }}</loc>
        <lastmod>{{ $url['lastmod'] }}</lastmod>
        <changefreq>{{ $url['changefreq'] }}</changefreq>
        <priority>{{ $url['priority'] }}</priority>
        @if(!empty($url['image']))
        <image:image>
            <image:loc>{{ $url['image'] }}</image:loc>
            @if(!empty($url['image_title']))
            <image:title>{{ e($url['image_title']) }}</image:title>
            @endif
        </image:image>
        @endif
    </url>
@endforeach

{{-- ── YouTube Videos ──────────────────────────────────────────────────── --}}
@if(isset($videos) && $videos->isNotEmpty())
@foreach($videos as $video)
    @if($video->youtube_video_id)
    <url>
        <loc>{{ route('library') }}</loc>
        <lastmod>{{ $video->updated_at->toDateString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
        <video:video>
            <video:thumbnail_loc>https://img.youtube.com/vi/{{ $video->youtube_video_id }}/hqdefault.jpg</video:thumbnail_loc>
            <video:title>{{ e($video->title) }}</video:title>
            <video:description>{{ e($video->excerpt ?? $video->title) }}</video:description>
            <video:player_loc>https://www.youtube.com/embed/{{ $video->youtube_video_id }}</video:player_loc>
            @if($video->published_at)
            <video:publication_date>{{ $video->published_at->toIso8601String() }}</video:publication_date>
            @endif
            <video:family_friendly>yes</video:family_friendly>
        </video:video>
    </url>
    @endif
@endforeach
@endif

</urlset>
