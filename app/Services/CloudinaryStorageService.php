<?php

namespace App\Services;

use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CloudinaryStorageService
{
    /**
     * Singleton instance of Cloudinary client.
     */
    protected static ?Cloudinary $client = null;

    /**
     * Check if Cloudinary is configured.
     */
    public static function isConfigured(): bool
    {
        $url = config('cloudinary.cloud_url');
        if (!empty($url) && str_starts_with($url, 'cloudinary://')) {
            return true;
        }

        return !empty(config('cloudinary.cloud_name'))
            && !empty(config('cloudinary.api_key'))
            && !empty(config('cloudinary.api_secret'));
    }

    /**
     * Get or initialize the Cloudinary client.
     */
    public static function getClient(): Cloudinary
    {
        if (self::$client !== null) {
            return self::$client;
        }

        $cloudUrl = config('cloudinary.cloud_url');

        if (!empty($cloudUrl) && str_starts_with($cloudUrl, 'cloudinary://')) {
            self::$client = new Cloudinary($cloudUrl);
        } else {
            $config = Configuration::instance([
                'cloud' => [
                    'cloud_name' => config('cloudinary.cloud_name'),
                    'api_key' => config('cloudinary.api_key'),
                    'api_secret' => config('cloudinary.api_secret'),
                ],
                'url' => [
                    'secure' => config('cloudinary.secure', true),
                ],
            ]);
            self::$client = new Cloudinary($config);
        }

        return self::$client;
    }

    /**
     * Get the active fallback disk name for non-media or legacy files.
     */
    public static function disk(): string
    {
        return config('filesystems.default', 'public');
    }

    /**
     * Upload a file to Cloudinary (or fallback storage disk).
     *
     * @param UploadedFile|string $file Uploaded file instance or local path
     * @param string $folder Directory folder name (e.g. 'avatars', 'listings')
     * @param string|null $customFilename Optional custom filename
     * @return string Public secure HTTPS URL or local storage path
     */
    public static function upload(UploadedFile|string $file, string $folder = 'uploads', ?string $customFilename = null): string
    {
        if (self::isConfigured()) {
            try {
                $client = self::getClient();

                // Determine file path for upload
                $filePath = $file instanceof UploadedFile ? $file->getRealPath() : $file;
                $originalName = $file instanceof UploadedFile ? $file->getClientOriginalName() : basename($file);
                $nameWithoutExt = pathinfo($originalName, PATHINFO_FILENAME);

                $publicId = $customFilename
                    ? pathinfo($customFilename, PATHINFO_FILENAME)
                    : Str::slug($nameWithoutExt) . '_' . time() . '_' . Str::random(6);

                $baseFolder = trim(config('cloudinary.folder', 'ebenta'), '/');
                $targetFolder = $baseFolder . '/' . trim($folder, '/');

                $uploadOptions = [
                    'folder' => $targetFolder,
                    'public_id' => $publicId,
                    'resource_type' => 'auto',
                    'overwrite' => true,
                ];

                $response = $client->uploadApi()->upload($filePath, $uploadOptions);

                if (!empty($response['secure_url'])) {
                    return $response['secure_url'];
                }
            } catch (\Throwable $e) {
                Log::error('Cloudinary upload failed, attempting local fallback: ' . $e->getMessage(), [
                    'exception' => $e,
                    'folder' => $folder,
                ]);
            }
        }

        // Fallback to standard Laravel disk upload
        $diskName = self::disk();
        $disk = Storage::disk($diskName);

        if ($file instanceof UploadedFile) {
            $extension = $file->getClientOriginalExtension() ?: 'jpg';
            $filename = $customFilename ?: (Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '_' . time() . '_' . Str::random(8) . '.' . $extension);
            $path = $disk->putFileAs($folder, $file, $filename);

            if (!$path) {
                $path = $disk->putFile($folder, $file);
            }

            return $path ?: '';
        }

        return '';
    }

    /**
     * Delete an asset by URL or path.
     *
     * @param string|null $pathOrUrl
     * @return bool
     */
    public static function delete(?string $pathOrUrl): bool
    {
        if (empty($pathOrUrl)) {
            return false;
        }

        // Check if this is a Cloudinary URL
        if (str_contains($pathOrUrl, 'cloudinary.com')) {
            $publicId = self::extractPublicId($pathOrUrl);
            if ($publicId && self::isConfigured()) {
                try {
                    $client = self::getClient();
                    $client->uploadApi()->destroy($publicId, [
                        'resource_type' => 'image',
                        'invalidate' => true,
                    ]);
                    return true;
                } catch (\Throwable $e) {
                    Log::warning('Cloudinary delete failed: ' . $e->getMessage(), ['public_id' => $publicId]);
                }
            }
        }

        // Attempt deletion from local public disk
        $key = self::extractLocalKey($pathOrUrl);
        $deleted = false;

        try {
            if (Storage::disk('public')->exists($key)) {
                $deleted = Storage::disk('public')->delete($key) || $deleted;
            }
        } catch (\Throwable $e) {
            // Ignore
        }

        // Also check r2 disk if previously configured
        try {
            if (config('filesystems.disks.r2.key') && Storage::disk('r2')->exists($key)) {
                $deleted = Storage::disk('r2')->delete($key) || $deleted;
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

        // If already an absolute HTTP/HTTPS URL (Cloudinary, Cloudflare R2, Google Avatar, etc.)
        if (str_starts_with($pathOrUrl, 'http://') || str_starts_with($pathOrUrl, 'https://')) {
            return $pathOrUrl;
        }

        // Relative path stored on local storage disk
        return asset('storage/' . ltrim($pathOrUrl, '/'));
    }

    /**
     * Extract Cloudinary public_id from a Cloudinary URL.
     * Example: https://res.cloudinary.com/cloud/image/upload/v1234567890/ebenta/listings/item_1.jpg
     * Result: ebenta/listings/item_1
     */
    public static function extractPublicId(string $url): ?string
    {
        $parsed = parse_url($url, PHP_URL_PATH);
        if (!$parsed) {
            return null;
        }

        // Remove upload prefix and optional version prefix (e.g. /image/upload/v1234567890/...)
        $pattern = '#/(?:image|raw|video)/upload/(?:v\d+/)?(.*?)(?:\.[a-zA-Z0-9]+)?$#';
        if (preg_match($pattern, $parsed, $matches)) {
            return $matches[1];
        }

        return null;
    }

    /**
     * Extract local storage key from a path or full URL.
     */
    protected static function extractLocalKey(string $pathOrUrl): string
    {
        if (!str_starts_with($pathOrUrl, 'http://') && !str_starts_with($pathOrUrl, 'https://')) {
            return ltrim($pathOrUrl, '/');
        }

        $parsed = parse_url($pathOrUrl, PHP_URL_PATH);
        $path = ltrim($parsed ?: $pathOrUrl, '/');

        if (str_starts_with($path, 'storage/')) {
            $path = substr($path, 8);
        }

        return $path;
    }
}
