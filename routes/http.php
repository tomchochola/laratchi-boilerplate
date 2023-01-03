<?php

declare(strict_types=1);

resolveRouteRegistrar()->middleware('api')->prefix('api')->group(__DIR__.\DIRECTORY_SEPARATOR.'api.php');
resolveRouteRegistrar()->middleware('session')->group(__DIR__.\DIRECTORY_SEPARATOR.'session.php');
resolveRouteRegistrar()->group(__DIR__.\DIRECTORY_SEPARATOR.'blank.php');
