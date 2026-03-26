<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Admin Panel Path
    |--------------------------------------------------------------------------
    | Set ADMIN_PATH in .env to a secret slug. NEVER use "admin".
    | This path is not exposed in sitemap, robots.txt, or any public file.
    */
    'path' => env('ADMIN_PATH', 'manage'),

    /*
    |--------------------------------------------------------------------------
    | Allowed IPs (optional)
    |--------------------------------------------------------------------------
    | Comma-separated list of IPs allowed to access the admin panel.
    | Leave null to allow all IPs (rely on role check only).
    */
    'allowed_ips' => env('ADMIN_ALLOWED_IPS'),
];
