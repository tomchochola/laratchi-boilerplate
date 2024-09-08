<?php

declare(strict_types=1);

use Tomchochola\Laratchi\Config\Env;
use Tomchochola\Laratchi\Support\Resolver;

$env = Env::inject();
$app = Resolver::resolveApp();

return [
    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => 'local',

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been set up for each driver as an example of the required values.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [
        'local' => [
            'driver' => 'local',
            'root' => $app->storagePath('app'),
            'throw' => true,
        ],

        'public' => $env->appEnvIs(['production'])
            ? [
                'driver' => 's3',
                'key' => $env->mustParseString('AWS_ACCESS_KEY_ID'),
                'secret' => $env->mustParseString('AWS_SECRET_ACCESS_KEY'),
                'region' => $env->mustParseString('AWS_DEFAULT_REGION'),
                'bucket' => $env->mustParseString('AWS_BUCKET'),
                'url' => $env->parseNullableString('AWS_URL'),
                'endpoint' => null,
                'use_path_style_endpoint' => false,
                'throw' => true,
            ]
            : [
                'driver' => 'local',
                'root' => $app->storagePath('app/public'),
                'url' => $env->mustParseString('APP_URL') . '/storage',
                'visibility' => 'public',
                'throw' => false,
            ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        $app->publicPath('storage') => $app->storagePath('app/public'),
    ],
];
