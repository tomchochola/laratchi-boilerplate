<?php

declare(strict_types=1);

use Illuminate\Support\Str;
use Tomchochola\Laratchi\Config\Env;

$env = Env::inject();

return [
    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => 'mysql',

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [
        'mysql' => [
            'driver' => 'mysql',
            'url' => null,
            'host' => $env->mustParseNullableString('DB_HOST') ?? '127.0.0.1',
            'port' => $env->mustParseNullableInt('DB_PORT') ?? 3306,
            'database' => $env->mustParseString('DB_DATABASE'),
            'username' => $env->mustParseString('DB_USERNAME'),
            'password' => $env->mustParseNullableString('DB_PASSWORD'),
            'unix_socket' => $env->mustParseNullableString('DB_SOCKET'),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_0900_ai_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => [],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer body of commands than a typical key-value system
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [
        'client' => 'phpredis',

        'options' => [
            'cluster' => 'redis',
            'prefix' => $env->parseNullableString('REDIS_PREFIX') ?? '{' . Str::slug($env->mustParseString('APP_NAME') . '_' . $env->appEnv() . '_database', '_') . '}',
        ],

        'default' => [
            'url' => null,
            'host' => $env->mustParseNullableString('REDIS_HOST') ?? '127.0.0.1',
            'username' => $env->mustParseNullableString('REDIS_USERNAME'),
            'password' => $env->mustParseNullableString('REDIS_PASSWORD'),
            'port' => $env->mustParseNullableInt('REDIS_PORT') ?? 6379,
            'database' => '0',
            'scheme' => $env->parseNullableString('REDIS_SCHEME') ?? 'tcp',
        ],

        'cache' => [
            'url' => null,
            'host' => $env->mustParseNullableString('REDIS_HOST') ?? '127.0.0.1',
            'username' => $env->mustParseNullableString('REDIS_USERNAME'),
            'password' => $env->mustParseNullableString('REDIS_PASSWORD'),
            'port' => $env->mustParseNullableInt('REDIS_PORT') ?? 6379,
            'database' => '1',
            'scheme' => $env->parseNullableString('REDIS_SCHEME') ?? 'tcp',
        ],
    ],
];
