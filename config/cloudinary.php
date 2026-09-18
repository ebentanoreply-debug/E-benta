<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Cloudinary Configuration
    |--------------------------------------------------------------------------
    |
    | Credentials and configuration for Cloudinary image and video management.
    |
    */
    'cloud_url' => env('CLOUDINARY_URL'),
    'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
    'api_key' => env('CLOUDINARY_API_KEY'),
    'api_secret' => env('CLOUDINARY_API_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | Default Upload Folder
    |--------------------------------------------------------------------------
    |
    | Base folder prefix for all uploaded assets within your Cloudinary account.
    |
    */
    'folder' => env('CLOUDINARY_FOLDER', 'ebenta'),

    /*
    |--------------------------------------------------------------------------
    | Secure URLs
    |--------------------------------------------------------------------------
    |
    | Always serve assets through HTTPS.
    |
    */
    'secure' => env('CLOUDINARY_SECURE', true),
];
