<?php

namespace App\Services;

/**
 * Class CloudflareStorageService
 *
 * Maintained as an alias to CloudinaryStorageService for backward compatibility.
 * All media operations seamlessly route through CloudinaryStorageService.
 */
class CloudflareStorageService extends CloudinaryStorageService
{
    // Inherits all upload, delete, url, disk, isConfigured methods from CloudinaryStorageService
}
