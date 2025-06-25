<?php

// Railway specific configuration overrides
return [
    // Disable debug in production
    'debug' => env('APP_DEBUG', false),
    
    // Use errorlog for Railway
    'log_channel' => env('LOG_CHANNEL', 'errorlog'),
    
    // Optimize for Railway environment
    'cache' => [
        'default' => env('CACHE_STORE', 'database'),
    ],
    
    // Session configuration for Railway
    'session' => [
        'driver' => env('SESSION_DRIVER', 'database'),
        'lifetime' => env('SESSION_LIFETIME', 120),
        'encrypt' => false,
        'files' => storage_path('framework/sessions'),
        'connection' => null,
        'table' => 'sessions',
        'store' => null,
        'lottery' => [2, 100],
        'cookie' => env('SESSION_COOKIE', 'laravel_session'),
        'path' => '/',
        'domain' => env('SESSION_DOMAIN', null),
        'secure' => env('SESSION_SECURE_COOKIE', true),
        'http_only' => true,
        'same_site' => 'lax',
    ],
];
