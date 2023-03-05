<?php

declare(strict_types=1);

namespace App\Providers;

use App\Http\Resources\MeResource;
use Tomchochola\Laratchi\Providers\LaratchiServiceProvider as LaratchiLaratchiServiceProvider;
use Tomchochola\Laratchi\Validation\SecureValidator;

class LaratchiServiceProvider extends LaratchiLaratchiServiceProvider
{
    /**
     * @inheritDoc
     */
    public function register(): void
    {
        parent::register();

        // Set me resource used in Tomchochola\Laratchi\Auth\Http\Controllers\*::class
        static::$meResource = MeResource::class;

        // Set extra validation messages
        SecureValidator::$customMsgs = [];

        // Tip to $this->app->bind() Tomchochola\Laratchi\Auth\Actions\CanLoginAction::class to global authorize authed users
        // Tip to $this->app->bind() Tomchochola\Laratchi\Auth\Http\Validation\AuthValidity::class to modify auth routes validation
        // Tip to $this->app->bind() Tomchochola\Laratchi\Auth\DatabaseToken::class to modify database token functions
        // Tip to $this->app->bind() Tomchochola\Laratchi\Auth\Actions\*::class to modify auth system actions
        // Tip to $this->app->bind() Tomchochola\Laratchi\Auth\Http\Requests\*::class to modify auth system data validation

        // Review static::class static properties
        // Review Tomchochola\Laratchi\Auth\Http\Controllers\*::class static properties
        // Review Tomchochola\Laratchi\Auth\Http\Validation\AuthValidity::class static properties
        // Review Tomchochola\Laratchi\Validation\SecureValidator::class static properties

        // See nice validation rules Tomchochola\Laratchi\Validation\Rules\*::class and their static properties
        // See nice middlewares Tomchochola\Laratchi\Http\Middleware\*::class
        // See nice image fakery Tomchochola\Laratchi\Testing\Support\MediaSeedSupport::class
    }
}
