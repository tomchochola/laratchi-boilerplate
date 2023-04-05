<?php

declare(strict_types=1);

use Illuminate\Support\Str;

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
            'host' => mustEnvString('DB_HOST', '127.0.0.1'),
            'port' => mustEnvInt('DB_PORT', 3306),
            'database' => mustEnvString('DB_DATABASE'),
            'username' => mustEnvString('DB_USERNAME'),
            'password' => envString('DB_PASSWORD'),
            'unix_socket' => isEnv(['development', 'staging', 'production']) ? mustEnvString('DB_SOCKET', '/var/run/mysqld/mysqld.sock') : envString('DB_SOCKET'),
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
            'prefix' => Str::slug(mustEnvString('APP_NAME'), '_').'_'.currentEnv().'_database_',
        ],

        'default' => [
            'url' => null,
            'host' => mustEnvString('REDIS_HOST', '127.0.0.1'),
            'username' => envString('REDIS_USERNAME'),
            'password' => envString('REDIS_PASSWORD'),
            'port' => mustEnvInt('REDIS_PORT', 6379),
            'database' => '0',
        ],

        'cache' => [
            'url' => null,
            'host' => mustEnvString('REDIS_HOST', '127.0.0.1'),
            'username' => envString('REDIS_USERNAME'),
            'password' => envString('REDIS_PASSWORD'),
            'port' => mustEnvInt('REDIS_PORT', 6379),
            'database' => '1',
        ],
    ],
];
