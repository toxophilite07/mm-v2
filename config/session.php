<?php

use Illuminate\Support\Str;

return [

    /*
    |----------------------------------------------------------------------
    | Default Session Driver
    |----------------------------------------------------------------------
    |
    | This option controls the default session "driver" that will be used on
    | requests. By default, we will use the lightweight native driver but
    | you may specify any of the other wonderful drivers provided here.
    |
    | Supported: "file", "cookie", "database", "apc",
    |            "memcached", "redis", "dynamodb", "array"
    |
    */
    'driver' => env('SESSION_DRIVER', 'file'),

    /*
    |----------------------------------------------------------------------
    | Session Lifetime
    |----------------------------------------------------------------------
    |
    | Here you may specify the number of minutes that you wish the session
    | to be allowed to remain idle before it expires. If you want them
    | to immediately expire on the browser closing, set that option.
    |
    */
    'lifetime' => env('SESSION_LIFETIME', 1),
    'expire_on_close' => true,
    
    'remember_lifetime' => env('SESSION_REMEMBER_LIFETIME', 120), // Lifetime in minutes

    /*
    |----------------------------------------------------------------------
    | Session Encryption
    |----------------------------------------------------------------------
    |
    | This option allows you to easily specify that all of your session data
    | should be encrypted before it is stored. All encryption will be run
    | automatically by Laravel and you can use the Session like normal.
    |
    */
    'encrypt' => true,

    /*
    |----------------------------------------------------------------------
    | Session File Location
    |----------------------------------------------------------------------
    |
    | When using the native session driver, we need a location where session
    | files may be stored. A default has been set for you but a different
    | location may be specified. This is only needed for file sessions.
    |
    */
    'files' => storage_path('framework/sessions'),

    /*
    |----------------------------------------------------------------------
    | Session Cookie Settings
    |----------------------------------------------------------------------
    |
    | Here you can configure the settings related to the session cookies,
    | including its name, path, domain, and security-related options such as
    | HttpOnly, Secure, and SameSite attributes.
    |
    */
    'csrf_cookie' => [
    'http_only' => true, // Makes the CSRF cookie HTTP-only.
    ],

    'cookie' => env('SESSION_COOKIE', Str::slug(env('APP_NAME', 'laravel'), '_').'_session'),
    // 'cookie' => '',

    'path' => '/',
    'domain' => env('SESSION_DOMAIN'),

    // 'secure' => env('SESSION_SECURE_COOKIE', true), // Enforces cookies over HTTPS
    // 'http_only' => true,                            // Makes cookies inaccessible to JavaScript
    // 'same_site' => 'Strict',                        // Limits cookies to same-site requests
    'secure' => true,       // Only send over HTTPS.
    'http_only' => true,    // Hide cookies from JavaScript.
    'same_site' => 'strict', // Avoid cross-site transmission.

    /*
    |----------------------------------------------------------------------
    | Session Database Connection
    |----------------------------------------------------------------------
    |
    | When using the "database" or "redis" session drivers, you may specify a
    | connection that should be used to manage these sessions. This should
    | correspond to a connection in your database configuration options.
    |
    */
    'connection' => env('SESSION_CONNECTION'),

    /*
    |----------------------------------------------------------------------
    | Session Database Table
    |----------------------------------------------------------------------
    |
    | When using the "database" session driver, you may specify the table we
    | should use to manage the sessions. Of course, a sensible default is
    | provided for you; however, you are free to change this as needed.
    |
    */
    'table' => 'sessions',

    /*
    |----------------------------------------------------------------------
    | Session Cache Store
    |----------------------------------------------------------------------
    |
    | While using one of the framework's cache-driven session backends, you may
    | list a cache store that should be used for these sessions. This value
    | must match with one of the application's configured cache "stores".
    |
    | Affects: "apc", "dynamodb", "memcached", "redis"
    |
    */
    'store' => env('SESSION_STORE'),

    /*
    |----------------------------------------------------------------------
    | Session Sweeping Lottery
    |----------------------------------------------------------------------
    |
    | Some session drivers must manually sweep their storage location to get
    | rid of old sessions from storage. Here are the chances that it will
    | happen on a given request. By default, the odds are 2 out of 100.
    |
    */
    'lottery' => [2, 100],
];
