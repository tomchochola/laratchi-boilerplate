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

resolveRouteRegistrar()->prefix('v1/auth')->group(static function (): void {
    resolveRouter()->post('login', Tomchochola\Laratchi\Auth\Http\Controllers\LoginController::class);
    resolveRouter()->post('register', Tomchochola\Laratchi\Auth\Http\Controllers\RegisterController::class);
    resolveRouter()->post('logout_current', Tomchochola\Laratchi\Auth\Http\Controllers\LogoutCurrentDeviceController::class);
    resolveRouter()->post('logout_other', Tomchochola\Laratchi\Auth\Http\Controllers\LogoutOtherDevicesController::class);
});

resolveRouteRegistrar()->prefix('v1/password')->group(static function (): void {
    resolveRouter()->post('forgot', Tomchochola\Laratchi\Auth\Http\Controllers\PasswordForgotController::class);
    resolveRouter()->post('reset', Tomchochola\Laratchi\Auth\Http\Controllers\PasswordResetController::class);
    resolveRouter()->post('update', Tomchochola\Laratchi\Auth\Http\Controllers\PasswordUpdateController::class);
});

resolveRouteRegistrar()->prefix('v1/email_verification')->group(static function (): void {
    resolveRouter()->post('resend', Tomchochola\Laratchi\Auth\Http\Controllers\EmailVerificationResendController::class);
    resolveRouter()->post('verify', Tomchochola\Laratchi\Auth\Http\Controllers\EmailVerificationVerifyController::class);
});

resolveRouteRegistrar()->prefix('v1/me')->group(static function (): void {
    resolveRouter()->get('show', Tomchochola\Laratchi\Auth\Http\Controllers\MeShowController::class);
    resolveRouter()->post('destroy', Tomchochola\Laratchi\Auth\Http\Controllers\MeDestroyController::class);
    resolveRouter()->post('update', Tomchochola\Laratchi\Auth\Http\Controllers\MeUpdateController::class);
});

resolveRouter()->any('{any?}', Tomchochola\Laratchi\Http\Controllers\NotFoundController::class)->where('any', '.*')->fallback();
