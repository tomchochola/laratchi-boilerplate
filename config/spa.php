<?php

declare(strict_types=1);

use Tomchochola\Laratchi\Config\Env;

$env = Env::inject();

return [
    'url' => [
        'cs' => $env->mustParseString('SPA_URL_CS'),
        'en' => $env->mustParseString('SPA_URL_EN'),
    ],
];
