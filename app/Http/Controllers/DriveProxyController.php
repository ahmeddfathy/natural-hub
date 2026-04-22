<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DriveProxyController extends Controller
{
    public function stream(Request $request, string $fileId)
    {
        if (!preg_match('/^[a-zA-Z0-9_-]{20,}$/', $fileId)) {
            abort(400);
        }

        // Step 1: resolve the real download URL (Drive redirects through a confirm page)
        $downloadUrl = $this->resolveDownloadUrl($fileId);

        if (!$downloadUrl) {
            abort(502, 'Could not resolve Drive download URL');
        }

        // Step 2: stream the video with range support
        $rangeHeader = $request->header('Range', '');

        $ch = curl_init($downloadUrl);
        curl_setopt_array($ch, [
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_RETURNTRANSFER => false,
            CURLOPT_HEADER         => false,
            CURLOPT_USERAGENT      => 'Mozilla/5.0',
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_TIMEOUT        => 0,
        ]);

        if ($rangeHeader) {
            curl_setopt($ch, CURLOPT_RANGE, str_replace('bytes=', '', $rangeHeader));
        }

        // Capture response headers
        $responseHeaders = [];
        $httpStatus = 200;

        curl_setopt($ch, CURLOPT_HEADERFUNCTION, function ($ch, $header) use (&$responseHeaders, &$httpStatus) {
            $len = strlen($header);
            $header = trim($header);

            if (preg_match('/^HTTP\/[\d.]+ (\d+)/', $header, $m)) {
                $httpStatus = (int) $m[1];
            } elseif (str_contains($header, ':')) {
                [$name, $value] = explode(':', $header, 2);
                $responseHeaders[strtolower(trim($name))] = trim($value);
            }

            return $len;
        });

        // Buffer to collect headers before streaming
        $headersReady = false;

        curl_setopt($ch, CURLOPT_WRITEFUNCTION, function ($ch, $data) use (&$headersReady, &$responseHeaders, &$httpStatus) {
            if (!$headersReady) {
                $headersReady = true;

                $contentType   = $responseHeaders['content-type']   ?? 'video/mp4';
                $contentLength = $responseHeaders['content-length']  ?? null;
                $contentRange  = $responseHeaders['content-range']   ?? null;

                $status = ($httpStatus === 206 || $contentRange) ? 206 : 200;

                http_response_code($status);
                header('Content-Type: ' . $contentType);
                header('Accept-Ranges: bytes');
                header('Cache-Control: public, max-age=3600');
                header('Access-Control-Allow-Origin: *');

                if ($contentLength) {
                    header('Content-Length: ' . $contentLength);
                }
                if ($contentRange) {
                    header('Content-Range: ' . $contentRange);
                }
            }

            echo $data;
            flush();

            return strlen($data);
        });

        return response()->stream(function () use ($ch) {
            curl_exec($ch);
            curl_close($ch);
        }, 200); // status overridden inside WRITEFUNCTION
    }

    private function resolveDownloadUrl(string $fileId): ?string
    {
        // Try direct download URL first
        $url = "https://drive.google.com/uc?export=download&id={$fileId}&confirm=t";

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_NOBODY         => true,
            CURLOPT_USERAGENT      => 'Mozilla/5.0',
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_TIMEOUT        => 15,
            CURLOPT_HEADER         => true,
            CURLOPT_COOKIEJAR      => '',
            CURLOPT_COOKIEFILE     => '',
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $location = curl_getinfo($ch, CURLINFO_REDIRECT_URL);
        curl_close($ch);

        // If it's a direct 200 or redirect to the actual file
        if ($httpCode === 200 || ($httpCode >= 301 && $httpCode <= 308 && $location)) {
            return $location ?: $url;
        }

        // Extract confirm token from response for large files
        if (preg_match('/confirm=([^&"\']+)/', $response, $m)) {
            return "https://drive.google.com/uc?export=download&id={$fileId}&confirm={$m[1]}";
        }

        return $url;
    }
}
