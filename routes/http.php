<?php

declare(strict_types=1);

use Tomchochola\Laratchi\Support\Resolver;

Resolver::resolveRouter()
    ->get('api/v1/spec', Tomchochola\Laratchi\Swagger\Http\Controllers\SwaggerController::class)
    ->defaults('url', Resolver::resolveUrlGenerator()->asset('docs/openapi_v1.json'));

Resolver::resolveRouteRegistrar()
    ->middleware('api')
    ->prefix('api')
    ->group(__DIR__.'/api.php');

Resolver::resolveRouteRegistrar()
    ->middleware('session')
    ->group(__DIR__.'/session.php');
