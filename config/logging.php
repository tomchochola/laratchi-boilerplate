<?php

declare(strict_types=1);

use Monolog\Handler\NullHandler;
use Tomchochola\Laratchi\Config\Env;
use Tomchochola\Laratchi\Support\Resolver;

$env = Env::inject();
$app = Resolver::resolveApp();

$level =
    $env->parseNullableString('LOG_LEVEL') ??
    $env->appEnvMap([
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

    'default' => $env->parseNullableString('LOG_DRIVER') ??
        $env->appEnvMap([
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
        'channel' => $env->parseNullableString('LOG_DEPRECATIONS_DRIVER') ??
            $env->appEnvMap([
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
            'path' => $app->storagePath('logs/laravel.log'),
            'level' => $level,
            'replace_placeholders' => true,
        ],

        'daily' => [
            'driver' => 'daily',
            'path' => $app->storagePath('logs/laravel.log'),
            'level' => $level,
            'days' => 14,
            'replace_placeholders' => true,
        ],

        'null' => [
            'driver' => 'monolog',
            'handler' => NullHandler::class,
        ],

        'emergency' => [
            'path' => $app->storagePath('logs/laravel.log'),
        ],
    ],
];
