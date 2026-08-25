<?php

use Illuminate\Support\Facades\Route;

Route::get('/debug-google-config', function () {
    return [
        'client_id' => config('services.google.client_id'),
        'redirect_uri' => config('services.google.redirect'),
        'env_callback_url' => env('GOOGLE_CALLBACK_URL'),
        'app_url' => config('app.url'),
    ];
});
