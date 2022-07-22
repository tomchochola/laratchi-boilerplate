<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Tomchochola\Laratchi\Support\ServiceProvider as VendorLaratchiServiceProvider;

class LaratchiServiceProvider extends ServiceProvider
{
    /**
     * All of the container singletons that should be registered.
     *
     * @var array<class-string, class-string>
     */
    public array $singletons = [
        // \Tomchochola\Laratchi\Auth\Http\Validation\AuthValidity::class => \App\Http\Validation\AuthValidity::class,
        // \Tomchochola\Laratchi\Validation\MediaValidity::class => \App\Http\Validation\MediaValidity::class,
        // \Tomchochola\Laratchi\Validation\GenericValidity::class => \App\Http\Validation\GenericValidity::class,
    ];

    /**
     * @inheritDoc
     */
    public function register(): void
    {
        parent::register();

        // Unguard models and prevent lazy loading
        VendorLaratchiServiceProvider::modelRestrictions();

        // Override user json api resource
        // \Tomchochola\Laratchi\Auth\Services\AuthService::$jsonApiResource = \App\Http\Resources\MeJsonApiResource::class;

        // Override default validator
        // \Tomchochola\Laratchi\Http\Middleware\SwapValidatorMiddleware::$secureValidator = \Tomchochola\Laratchi\Validation\StrictSecureValidator::class or \Tomchochola\Laratchi\Validation\SecureValidator::class;

        // Override validated input error status
        // \Tomchochola\Laratchi\Validation\ValidatedInput::$castFailedStatus = \Illuminate\Http\Response::HTTP_BAD_REQUEST;
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
    }
}
