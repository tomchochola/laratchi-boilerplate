<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

resolveRouteRegistrar()->prefix('v1')->group(static function (): void {
    resolveRouteRegistrar()->prefix('auth')->group(static function (): void {
        Tomchochola\Laratchi\Support\ServiceProvider::registerRoutes();
    });
});

resolveRouter()->any('{any?}', Tomchochola\Laratchi\Http\Controllers\NotFoundController::class)->where('any', '.*')->fallback();
