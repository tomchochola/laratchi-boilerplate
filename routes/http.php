<?php

declare(strict_types=1);

resolveRouteRegistrar()->middleware('api')->prefix('api')->group(__DIR__.'/api.php');
resolveRouteRegistrar()->middleware('session')->group(__DIR__.'/session.php');
resolveRouteRegistrar()->group(__DIR__.'/blank.php');
