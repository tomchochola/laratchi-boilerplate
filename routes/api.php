<?php

declare(strict_types=1);

use Illuminate\Routing\Router;
use Tomchochola\Laratchi\Support\Resolver;

Resolver::resolveRouteRegistrar()
    ->prefix('v1/auth')
    ->group(static function (Router $router): void {
        $router->post('login', Tomchochola\Laratchi\Auth\Http\Controllers\LoginController::class);
        $router->post('register', Tomchochola\Laratchi\Auth\Http\Controllers\RegisterController::class);
        $router->post('logout', Tomchochola\Laratchi\Auth\Http\Controllers\LogoutController::class);
    });

Resolver::resolveRouteRegistrar()
    ->prefix('v1/password')
    ->group(static function (Router $router): void {
        $router->post('forgot', Tomchochola\Laratchi\Auth\Http\Controllers\PasswordForgotController::class);
        $router->post('reset', Tomchochola\Laratchi\Auth\Http\Controllers\PasswordResetController::class);
        $router->post('update', Tomchochola\Laratchi\Auth\Http\Controllers\PasswordUpdateController::class);
    });

Resolver::resolveRouteRegistrar()
    ->prefix('v1/email_verification')
    ->group(static function (Router $router): void {
        $router->post('confirm', Tomchochola\Laratchi\Auth\Http\Controllers\EmailConfirmationController::class);
    });

Resolver::resolveRouteRegistrar()
    ->prefix('v1/me')
    ->group(static function (Router $router): void {
        $router->get('show', Tomchochola\Laratchi\Auth\Http\Controllers\MeShowController::class);
        $router->post('destroy', Tomchochola\Laratchi\Auth\Http\Controllers\MeDestroyController::class);
        $router->post('update', Tomchochola\Laratchi\Auth\Http\Controllers\MeUpdateController::class);
    });

Resolver::resolveRouteRegistrar()
    ->any('{any?}', Tomchochola\Laratchi\Http\Controllers\NotFoundController::class)
    ->where('any', '.*');
