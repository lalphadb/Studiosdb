<?php

return [
    'fonts' => [
        'bunny' => env('USE_BUNNY_FONTS', true),
        'google' => env('USE_GOOGLE_FONTS', false),
    ],
    
    'cdn' => [
        'enabled' => env('CDN_ENABLED', false),
        'url' => env('CDN_URL', ''),
    ],
    
    'csp' => [
        'enabled' => env('CSP_ENABLED', true),
        'report_only' => env('CSP_REPORT_ONLY', false),
    ],
];
