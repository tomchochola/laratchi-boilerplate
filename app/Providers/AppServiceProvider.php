<?php

declare(strict_types=1);

namespace App\Providers;

use Tomchochola\Laratchi\Auth\DatabaseToken as LaratchiDatabaseToken;
use Tomchochola\Laratchi\Auth\Http\Validation\AuthValidity as LaratchiAuthValidity;
use Tomchochola\Laratchi\Auth\Notifications\EmailConfirmationNotification as LaratchiEmailConfirmationNotification;
use Tomchochola\Laratchi\Auth\Notifications\EmailVerificationNotification as LaratchiEmailVerificationNotification;
use Tomchochola\Laratchi\Auth\Notifications\PasswordInitNotification as LaratchiPasswordInitNotification;
use Tomchochola\Laratchi\Auth\Notifications\PasswordResetNotification as LaratchiPasswordResetNotification;
use Tomchochola\Laratchi\Auth\Services\CanLoginService as LaratchiCanLoginService;
use Tomchochola\Laratchi\Auth\Services\EmailBrokerService as LaratchiEmailBrokerService;
use Tomchochola\Laratchi\Providers\LaratchiServiceProvider as LaratchiLaratchiServiceProvider;
use Tomchochola\Laratchi\Validation\SecureValidator as LaratchiSecureValidator;
use Tomchochola\Laratchi\Validation\Validity as LaratchiValidity;
use Tomchochola\Laratchi\View\Services\ViewService as LaratchiViewService;

class AppServiceProvider extends LaratchiLaratchiServiceProvider
{
    /**
     * @inheritDoc
     */
    public function register(): void
    {
        parent::register();

        LaratchiAuthValidity::$template = LaratchiAuthValidity::class;
        LaratchiDatabaseToken::$template = LaratchiDatabaseToken::class;
        LaratchiViewService::$template = LaratchiViewService::class;
        LaratchiCanLoginService::$template = LaratchiCanLoginService::class;
        LaratchiEmailBrokerService::$template = LaratchiEmailBrokerService::class;
        LaratchiEmailConfirmationNotification::$template = LaratchiEmailConfirmationNotification::class;
        LaratchiEmailVerificationNotification::$template = LaratchiEmailVerificationNotification::class;
        LaratchiPasswordInitNotification::$template = LaratchiPasswordInitNotification::class;
        LaratchiPasswordResetNotification::$template = LaratchiPasswordResetNotification::class;
        LaratchiValidity::$template = LaratchiValidity::class;

        LaratchiSecureValidator::$customMsgs = [];
    }
}
