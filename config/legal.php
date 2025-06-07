<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Informations légales - Studios Unis
    |--------------------------------------------------------------------------
    */

    'company' => [
        'name' => 'Studios Unis',
        'email' => env('LEGAL_EMAIL', 'info@studiosunis.com'),
        'phone' => env('LEGAL_PHONE', '(514) 555-0123'),
        'address' => env('LEGAL_ADDRESS', 'Montréal, Québec'),
    ],

    'privacy_officer' => [
        'name' => env('PRIVACY_OFFICER_NAME', 'Responsable de la protection des données'),
        'email' => env('PRIVACY_OFFICER_EMAIL', 'privacy@studiosunis.com'),
    ],

    'loi25' => [
        'enabled' => true,
        'consent_required' => true,
        'retention_days' => 365 * 2, // 2 ans
        'audit_enabled' => true,
    ],
];
