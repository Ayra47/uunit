<?php

return [
    /*-------------------------------------------------------------------------
    | Default Bot Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the bots you wish to use as
    | your default bot for regular use.
    |
    */

    'default' => 'error_bot',

    /*-------------------------------------------------------------------------
    | Your Telegram Bots
    |--------------------------------------------------------------------------
    | You may use multiple bots. Each bot that you own should be configured here.
    |
    | See the docs for parameters specification:
    | https://westacks.github.io/telebot/#/configuration
    |
    */

    'bots' => [
        'bot' => [
            'token' => env('5867304536:AAGuWsvOMsR-_-r1rIcsbmyRFPfkHzZPSbA'),
        //     'name' => env('TELEGRAM_BOT_NAME', null),
        //     'api_url' => env('TELEGRAM_API_URL', 'https://api.telegram.org/bot{TOKEN}/{METHOD}'),
        //     'exceptions' => true,
        //     'async' => false,

        //     'webhook' => [
        //         // 'url'               => env('TELEGRAM_BOT_WEBHOOK_URL', env('APP_URL').'/telebot/webhook/bot/'.env('TELEGRAM_BOT_TOKEN')),
        //         // 'certificate'       => env('TELEGRAM_BOT_CERT_PATH', storage_path('app/ssl/public.pem')),
        //         // 'ip_address'        => '8.8.8.8',
        //         // 'max_connections'   => 40,
        //         // 'allowed_updates'   => ["message", "edited_channel_post", "callback_query"],
        //         // 'secret_token'      => env('TELEGRAM_KEY', null),
        //     ],

        //     'poll' => [
        //         // 'limit'             => 100,
        //         // 'timeout'           => 0,
        //         // 'allowed_updates'   => ["message", "edited_channel_post", "callback_query"]
        //     ],

        //     'handlers' => [
        //         // Your update handlers
        //     ],
        ],

        'error_bot' => [
            'token' => '6140578446:AAFhkMlkkbZEfzfQN4QfuxCsKyCBjbjKZwQ',
        ],
    ],
];
