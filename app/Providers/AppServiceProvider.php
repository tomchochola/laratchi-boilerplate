<?php

declare(strict_types=1);

namespace App\Providers;

use App\Http\Requests\Api\Auth\MeUpdateRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use Illuminate\Validation\Rules\Password;
use Tomchochola\Laratchi\Auth\Http\Requests\MeUpdateRequest as LaratchiMeUpdateRequest;
use Tomchochola\Laratchi\Auth\Http\Requests\RegisterRequest as LaratchiRegisterRequest;
use Tomchochola\Laratchi\Providers\LaratchiServiceProvider as LaratchiLaratchiServiceProvider;

class AppServiceProvider extends LaratchiLaratchiServiceProvider
{
    /**
     * @inheritDoc
     */
    public function register(): void
    {
        Password::defaults(static fn(): Password => Password::min(8));

        $this->app->bind(LaratchiRegisterRequest::class, RegisterRequest::class);
        $this->app->bind(LaratchiMeUpdateRequest::class, MeUpdateRequest::class);

        parent::register();
    }
}
