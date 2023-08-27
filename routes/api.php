<?php

declare(strict_types=1);

use Tomchochola\Laratchi\Support\Resolver;

Resolver::resolveRouteRegistrar()
    ->prefix('v1/auth')
    ->group(static function (): void {
        Resolver::resolveRouter()->post('login', Tomchochola\Laratchi\Auth\Http\Controllers\LoginController::class);
        Resolver::resolveRouter()->post('register', Tomchochola\Laratchi\Auth\Http\Controllers\RegisterController::class);
        Resolver::resolveRouter()->post('logout', Tomchochola\Laratchi\Auth\Http\Controllers\LogoutController::class);
    });

Resolver::resolveRouteRegistrar()
    ->prefix('v1/password')
    ->group(static function (): void {
        Resolver::resolveRouter()->post('forgot', Tomchochola\Laratchi\Auth\Http\Controllers\PasswordForgotController::class);
        Resolver::resolveRouter()->post('reset', Tomchochola\Laratchi\Auth\Http\Controllers\PasswordResetController::class);
        Resolver::resolveRouter()->post('update', Tomchochola\Laratchi\Auth\Http\Controllers\PasswordUpdateController::class);
    });

Resolver::resolveRouteRegistrar()
    ->prefix('v1/email_verification')
    ->group(static function (): void {
        Resolver::resolveRouter()->post('confirm', Tomchochola\Laratchi\Auth\Http\Controllers\EmailConfirmationController::class);
    });

Resolver::resolveRouteRegistrar()
    ->prefix('v1/me')
    ->group(static function (): void {
        Resolver::resolveRouter()->get('show', Tomchochola\Laratchi\Auth\Http\Controllers\MeShowController::class);
        Resolver::resolveRouter()->post('destroy', Tomchochola\Laratchi\Auth\Http\Controllers\MeDestroyController::class);
        Resolver::resolveRouter()->post('update', Tomchochola\Laratchi\Auth\Http\Controllers\MeUpdateController::class);
    });

Resolver::resolveRouter()
    ->any('{any?}', Tomchochola\Laratchi\Http\Controllers\NotFoundController::class)
    ->where('any', '.*');
