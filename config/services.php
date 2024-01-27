<?php

declare(strict_types=1);

use Tomchochola\Laratchi\Config\Env;

$env = Env::inject();

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
        'domain' => $env->mustParseNullableString('MAILGUN_DOMAIN'),
        'secret' => $env->mustParseNullableString('MAILGUN_SECRET'),
        'endpoint' => $env->mustParseNullableString('MAILGUN_ENDPOINT') ?? 'api.eu.mailgun.net',
        'scheme' => 'https',
    ],
];
