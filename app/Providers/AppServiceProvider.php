<?php

declare(strict_types=1);

namespace App\Providers;

use Tomchochola\Laratchi\Auth\DatabaseToken as LaratchiDatabaseToken;
use Tomchochola\Laratchi\Auth\Http\Validation\AuthValidity as LaratchiAuthValidity;
use Tomchochola\Laratchi\Auth\Services\CanLoginService as LaratchiCanLoginService;
use Tomchochola\Laratchi\Auth\Services\EmailBrokerService as LaratchiEmailBrokerService;
use Tomchochola\Laratchi\Providers\LaratchiServiceProvider as LaratchiLaratchiServiceProvider;
use Tomchochola\Laratchi\Validation\SecureValidator as LaratchiSecureValidator;
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

        LaratchiSecureValidator::$customMsgs = [];
    }
}
