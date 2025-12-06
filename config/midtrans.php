<?php

return [
    'merchant_id' => env('MIDTRANS_MERCHANT_ID', ''),
    'client_key' => env('MIDTRANS_CLIENT_KEY', ''),
    'server_key' => env('MIDTRANS_SERVER_KEY', ''),

    // Set to true for production, false for sandbox/testing
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),

    // Enable automatic sanitization
    'is_sanitized' => true,

    // Enable 3D Secure
    'is_3ds' => true,

    // CURL options - must include CURLOPT_HTTPHEADER as empty array to avoid error
    'curl_options' => [
        CURLOPT_SSL_VERIFYHOST => env('MIDTRANS_SSL_VERIFY', false) ? 2 : 0,
        CURLOPT_SSL_VERIFYPEER => env('MIDTRANS_SSL_VERIFY', false),
        CURLOPT_HTTPHEADER => [], // Required to prevent "Undefined array key 10023" error
    ],
];
