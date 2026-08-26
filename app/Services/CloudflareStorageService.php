<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CloudflareStorageService
{
    /**
     * Get the active upload storage disk.
     */
    public static function disk(): string
    {
        $defaultDisk = config('filesystems.default', 'local');
        if ($defaultDisk === 'r2' || $defaultDisk === 's3') {
            return $defaultDisk;
        }

        if (config('filesystems.disks.r2.key') && config('filesystems.disks.r2.bucket')) {
            return 'r2';
        }

        return 'public';
    }

    /**
     * Check if Cloudflare R2 is fully configured.
     */
    public static function isConfigured(): bool
    {
        return !empty(config('filesystems.disks.r2.key'))
            && !empty(config('filesystems.disks.r2.secret'))
            && !empty(config('filesystems.disks.r2.bucket'));
    }

    /**
     * Upload an uploaded file to Cloudflare R2 (or fallback disk).
     *
     * @param UploadedFile $file
     * @param string $folder Directory folder name (e.g. 'avatars', 'listings')
     * @param string|null $customFilename Optional custom filename
     * @return string The relative stored path or public URL
     */
    public static function upload(UploadedFile $file, string $folder = 'uploads', ?string $customFilename = null): string
    {
        $diskName = self::disk();
        $disk = Storage::disk($diskName);

        $extension = $file->getClientOriginalExtension() ?: 'jpg';
        $filename = $customFilename ?: (Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '_' . time() . '_' . Str::random(8) . '.' . $extension);

        // Upload to disk
        $path = $disk->putFileAs($folder, $file, $filename);

        if (!$path) {
            // Fallback storage attempt
            $path = $disk->putFile($folder, $file);
        }

        // If Cloudflare R2 public URL is configured, return the full public URL
        $r2Url = config('filesystems.disks.r2.url');
        if ($diskName === 'r2' && !empty($r2Url)) {
            return rtrim($r2Url, '/') . '/' . ltrim($path, '/');
        }

        return $path;
    }

    /**
     * Delete a file by path or full URL.
     *
     * @param string|null $pathOrUrl
     * @return bool
     */
    public static function delete(?string $pathOrUrl): bool
    {
        if (empty($pathOrUrl)) {
            return false;
        }

        $key = self::extractKey($pathOrUrl);
        $deleted = false;

        // Try deleting from R2 disk
        try {
            if (Storage::disk('r2')->exists($key)) {
                $deleted = Storage::disk('r2')->delete($key) || $deleted;
            }
        } catch (\Throwable $e) {
            // Ignore R2 connection issues if fallback
        }

        // Try deleting from public disk as well (for legacy or fallback files)
        try {
            if (Storage::disk('public')->exists($key)) {
                $deleted = Storage::disk('public')->delete($key) || $deleted;
            }
        } catch (\Throwable $e) {
            // Ignore
        }

        return $deleted;
    }

    /**
     * Resolve a public URL for a stored file path or URL.
     *
     * @param string|null $pathOrUrl
     * @return string|null
     */
    public static function url(?string $pathOrUrl): ?string
    {
        if (empty($pathOrUrl)) {
            return null;
        }

        // If already an absolute HTTP/HTTPS URL, return it directly
        if (str_starts_with($pathOrUrl, 'http://') || str_starts_with($pathOrUrl, 'https://')) {
            return $pathOrUrl;
        }

        $diskName = self::disk();
        $r2Url = config('filesystems.disks.r2.url');

        if ($diskName === 'r2' && !empty($r2Url)) {
            return rtrim($r2Url, '/') . '/' . ltrim($pathOrUrl, '/');
        }

        return asset('storage/' . ltrim($pathOrUrl, '/'));
    }

    /**
     * Extract the relative object storage key from a full URL or path.
     *
     * @param string $pathOrUrl
     * @return string
     */
    protected static function extractKey(string $pathOrUrl): string
    {
        if (!str_starts_with($pathOrUrl, 'http://') && !str_starts_with($pathOrUrl, 'https://')) {
            return ltrim($pathOrUrl, '/');
        }

        $parsed = parse_url($pathOrUrl, PHP_URL_PATH);
        $path = ltrim($parsed ?: $pathOrUrl, '/');

        // If path starts with 'storage/', strip it
        if (str_starts_with($path, 'storage/')) {
            $path = substr($path, 8);
        }

        return $path;
    }
}
