<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * Custom server.php for PHP built-in server
 * This bypasses artisan serve to avoid ServeCommand port issues
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// Serve static files as-is
if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
    return false;
}

// Bootstrap Laravel application
require_once __DIR__.'/public/index.php';
