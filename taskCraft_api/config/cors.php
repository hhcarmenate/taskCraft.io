<?php

$sessionDomain = env('SESSION_DOMAIN');
$allowedOriginsPattern = [
    'https://' . $sessionDomain,
    'http://' . $sessionDomain
];
$allowedSpaDomains = explode(',', env('ALLOWED_SPA_DOMAINS', ''));
$allowedOrigins = array_merge($allowedOriginsPattern, $allowedSpaDomains);


return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => $allowedOrigins,

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,
];
