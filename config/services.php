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
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'yahoo_api' => [
        'client_id' => env('YAHOO_CLIENT_ID'),
    ],

    'line_message_api' => [
        'channel_id' => env('LINE_MESSAGE_CHANNEL_ID'),
        'channel_secret' => env('LINE_MESSAGE_CHANNEL_SECRET'),
        'access_token' => env('LINE_MESSAGE_ACCESS_TOKEN'),
    ],

    'line_login' => [
        'client_id' => env('LINE_LOGIN_CHANNEL_ID'),
        'client_secret' => env('LINE_LOGIN_CHANNEL_SECRET'),
        'redirect' => env('LINE_LOGIN_REDIRECT_URI'),
    ],
];
