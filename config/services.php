<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'google' => [
        'client_id' => '224262085875-o6dg9jedi76aubbsvib42asvvsehs7l8.apps.googleusercontent.com',
        'client_secret' => 'GQrGtGkaeQjwV5Cl3qmOUKdB',
        'redirect' => 'http://localhost/DoAnChuyenNganh/public/auth/google/callback',
    ],
    'facebook' => [
        'client_id' => '1392743561058565',
        'client_secret' => '30070d0c20cc1eb2c35b8da08fb8724a',
        'redirect' => 'http://localhost/DoAnChuyenNganh/public/auth/facebook/callback',
    ],
];
