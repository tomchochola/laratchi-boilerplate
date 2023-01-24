<?php

declare(strict_types=1);

resolveRouter()->get('api/v1/spec', Tomchochola\Laratchi\Swagger\Http\Controllers\SwaggerUiController::class)->defaults('url', resolveUrlFactory()->asset('docs/openapi_v1.json'));
