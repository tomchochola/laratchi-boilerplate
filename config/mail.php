<?php

declare(strict_types=1);

use Tomchochola\Laratchi\Config\Env;
use Tomchochola\Laratchi\Support\Resolver;

$env = Env::inject();
$app = Resolver::resolveApp();

$driver = $env->appEnvMap([
    'local' => 'log',
    'testing' => 'array',
    'development' => 'smtp',
    'staging' => 'smtp',
    'production' => 'mailgun',
]);

return [
    /*
    |--------------------------------------------------------------------------
    | Default Mailer
    |--------------------------------------------------------------------------
    |
    | This option controls the default mailer that is used to send any email
    | messages sent by your application. Alternative mailers may be setup
    | and used as needed; however, this mailer will be used by default.
    |
    */

    'default' => $driver,

    /*
    |--------------------------------------------------------------------------
    | Mailer Configurations
    |--------------------------------------------------------------------------
    |
    | Here you may configure all of the mailers used by your application plus
    | their respective settings. Several examples have been configured for
    | you and you are free to add your own as your application requires.
    |
    | Laravel supports a variety of mail "transport" drivers to be used while
    | sending an e-mail. You will specify which one you are using for your
    | mailers below. You are free to add additional mailers as required.
    |
    | Supported: "smtp", "sendmail", "mailgun", "ses", "ses-v2",
    |            "postmark", "log", "array", "failover"
    |
    */

    'mailers' => [
        'smtp' => [
            'transport' => 'smtp',
            'url' => null,
            'host' => $driver === 'smtp' ? $env->mustParseString('MAIL_HOST') : $env->mustParseNullableString('MAIL_HOST'),
            'port' => $driver === 'smtp' ? $env->mustParseInt('MAIL_PORT') : $env->mustParseNullableInt('MAIL_PORT'),
            'encryption' => 'tls',
            'username' => $driver === 'smtp' ? $env->mustParseString('MAIL_USERNAME') : $env->mustParseNullableString('MAIL_USERNAME'),
            'password' => $driver === 'smtp' ? $env->mustParseString('MAIL_PASSWORD') : $env->mustParseNullableString('MAIL_PASSWORD'),
            'timeout' => null,
            'local_domain' => $env->mustParseNullableString('MAIL_EHLO_DOMAIN'),
        ],

        'mailgun' => [
            'transport' => 'mailgun',
            'client' => [
                'timeout' => 5,
            ],
        ],

        'log' => [
            'transport' => 'log',
            'channel' => 'info',
        ],

        'array' => [
            'transport' => 'array',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Global "From" Address
    |--------------------------------------------------------------------------
    |
    | You may wish for all e-mails sent by your application to be sent from
    | the same address. Here, you may specify a name and address that is
    | used globally for all e-mails that are sent by your application.
    |
    */

    'from' => [
        'address' => $env->mustParseString('MAIL_FROM_ADDRESS'),
        'name' => $env->mustParseString('MAIL_FROM_NAME'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Markdown Mail Settings
    |--------------------------------------------------------------------------
    |
    | If you are using Markdown based email rendering, you may configure your
    | theme and component paths here, allowing you to customize the design
    | of the emails. Or, you may simply stick with the Laravel defaults!
    |
    */

    'markdown' => [
        'theme' => 'default',

        'paths' => [$app->resourcePath('views/vendor/mail')],
    ],
];
