<?php

declare(strict_types=1);

resolveRouter()->get('api/v1/spec', Tomchochola\Laratchi\Swagger\Http\Controllers\SwaggerController::class)->defaults('url', resolveUrlFactory()->asset('docs/openapi_v1.json'));

resolveRouteRegistrar()->middleware('api')->prefix('api')->group(__DIR__.'/api.php');
resolveRouteRegistrar()->middleware('session')->group(__DIR__.'/session.php');
