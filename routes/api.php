<?php

declare(strict_types=1);

resolveRouteRegistrar()->prefix('v1/auth')->group(static function (): void {
    resolveRouter()->post('login', Tomchochola\Laratchi\Auth\Http\Controllers\LoginController::class);
    resolveRouter()->post('register', Tomchochola\Laratchi\Auth\Http\Controllers\RegisterController::class);
    resolveRouter()->post('logout', Tomchochola\Laratchi\Auth\Http\Controllers\LogoutController::class);
});

resolveRouteRegistrar()->prefix('v1/password')->group(static function (): void {
    resolveRouter()->post('forgot', Tomchochola\Laratchi\Auth\Http\Controllers\PasswordForgotController::class);
    resolveRouter()->post('reset', Tomchochola\Laratchi\Auth\Http\Controllers\PasswordResetController::class);
    resolveRouter()->post('update', Tomchochola\Laratchi\Auth\Http\Controllers\PasswordUpdateController::class);
});

resolveRouteRegistrar()->prefix('v1/email_verification')->group(static function (): void {
    resolveRouter()->post('confirm', Tomchochola\Laratchi\Auth\Http\Controllers\EmailConfirmationController::class);
});

resolveRouteRegistrar()->prefix('v1/me')->group(static function (): void {
    resolveRouter()->get('show', Tomchochola\Laratchi\Auth\Http\Controllers\MeShowController::class);
    resolveRouter()->post('destroy', Tomchochola\Laratchi\Auth\Http\Controllers\MeDestroyController::class);
    resolveRouter()->post('update', Tomchochola\Laratchi\Auth\Http\Controllers\MeUpdateController::class);
});

resolveRouter()->any('{any?}', Tomchochola\Laratchi\Http\Controllers\NotFoundController::class)->where('any', '.*');
