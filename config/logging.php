<?php

declare(strict_types=1);

use Monolog\Handler\NullHandler;

$level = mapEnv([
    'local' => 'debug',
    'testing' => 'debug',
    'development' => 'debug',
    'staging' => 'debug',
    'production' => 'info',
]);

return [
    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that gets used when writing
    | messages to the logs. The name specified in this option should match
    | one of the channels defined in the "channels" configuration array.
    |
    */

    'default' => mapEnv([
        'local' => 'single',
        'testing' => 'null',
        'development' => 'single',
        'staging' => 'single',
        'production' => 'single',
    ]),

    /*
    |--------------------------------------------------------------------------
    | Deprecations Log Channel
    |--------------------------------------------------------------------------
    |
    | This option controls the log channel that should be used to log warnings
    | regarding deprecated PHP and library features. This allows you to get
    | your application ready for upcoming major versions of dependencies.
    |
    */

    'deprecations' => [
        'channel' => mapEnv([
            'local' => 'single',
            'testing' => 'null',
            'development' => 'single',
            'staging' => 'single',
            'production' => 'single',
        ]),
        'trace' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "monolog",
    |                    "custom", "stack"
    |
    */

    'channels' => [
        'single' => [
            'driver' => 'single',
            'path' => resolveApp()->storagePath('logs/laravel.log'),
            'level' => $level,
        ],

        'daily' => [
            'driver' => 'daily',
            'path' => resolveApp()->storagePath('logs/laravel.log'),
            'level' => $level,
            'days' => 14,
        ],

        'null' => [
            'driver' => 'monolog',
            'handler' => NullHandler::class,
        ],

        'emergency' => [
            'path' => resolveApp()->storagePath('logs/laravel.log'),
        ],
    ],
];
