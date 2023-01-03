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
        resolveRouter()->post('login', Tomchochola\Laratchi\Auth\Http\Controllers\LoginController::class);
        resolveRouter()->post('register', Tomchochola\Laratchi\Auth\Http\Controllers\RegisterController::class);
        resolveRouter()->post('password/forgot', Tomchochola\Laratchi\Auth\Http\Controllers\PasswordForgotController::class);
        resolveRouter()->post('password/reset', Tomchochola\Laratchi\Auth\Http\Controllers\PasswordResetController::class);
        resolveRouter()->post('password/update', Tomchochola\Laratchi\Auth\Http\Controllers\PasswordUpdateController::class);
        resolveRouter()->post('email_verification/resend', Tomchochola\Laratchi\Auth\Http\Controllers\EmailVerificationResendController::class);
        resolveRouter()->post('email_verification/verify', Tomchochola\Laratchi\Auth\Http\Controllers\EmailVerificationVerifyController::class);
        resolveRouter()->post('logout/current', Tomchochola\Laratchi\Auth\Http\Controllers\LogoutCurrentDeviceController::class);
        resolveRouter()->post('logout/other', Tomchochola\Laratchi\Auth\Http\Controllers\LogoutOtherDevicesController::class);
        resolveRouter()->get('me', Tomchochola\Laratchi\Auth\Http\Controllers\MeShowController::class);
        resolveRouter()->post('me/destroy', Tomchochola\Laratchi\Auth\Http\Controllers\MeDestroyController::class);
        resolveRouter()->post('me/update', Tomchochola\Laratchi\Auth\Http\Controllers\MeUpdateController::class);
    });
});

resolveRouter()->any('{any?}', Tomchochola\Laratchi\Http\Controllers\NotFoundController::class)->where('any', '.*')->fallback();
