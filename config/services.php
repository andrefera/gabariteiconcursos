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

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI', '/auth/google/callback'),
    ],

    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect' => env('FACEBOOK_REDIRECT_URI', '/auth/facebook/callback'),
    ],

    'mercado_pago' => [
        'access_token' => env('MERCADOPAGO_ACCESS_TOKEN', 'TEST-8583111996650966-020815-c0922bfe9c3d38d09bd7743b369de6fe-1294252760'),
    ],

    'melhor_envio' => [
        'token' => env('MELHOR_ENVIO_TOKEN'),
        'url' => env('MELHOR_ENVIO_URL', 'https://sandbox.melhorenvio.com.br/api/v2/me/shipment/calculate'),
    ],

    'elastic_search' => [
        'products_index' => env('ELASTIC_SEARCH_INDEX_PRODUCTS', 'products_index'),
        'tls_host' => env('ELASTIC_SEARCH_TLS_HOST', '127.0.0.1:9200')
    ]
];
