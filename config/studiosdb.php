<?php

return [
    'auth' => [
        'lock_duration' => env('AUTH_LOCK_DURATION', 30), // minutes
        'max_attempts' => env('AUTH_MAX_ATTEMPTS', 5),
        'require_email_verification' => env('AUTH_REQUIRE_EMAIL_VERIFICATION', false),
    ],
    
    'logs' => [
        'retention_days' => env('LOG_RETENTION_DAYS', 365),
        'activity_log_enabled' => env('ACTIVITY_LOG_ENABLED', true),
    ],
    
    'session' => [
        'timeout_minutes' => env('SESSION_TIMEOUT', 120),
    ],
    
    'app' => [
        'name' => 'StudiosUnisDB',
        'version' => '1.0',
        'description' => 'Système de gestion pour écoles d\'arts martiaux',
    ],
    
    'features' => [
        'qr_codes' => true,
        'exports' => true,
        'activity_logs' => true,
        'two_factor' => false,
        'api' => false,
    ],
];
