<?php

declare(strict_types=1);

namespace App\Providers;

use App\Http\Resources\MeJsonApiResource;
use Tomchochola\Laratchi\Auth\Services\AuthService;
use Tomchochola\Laratchi\Providers\LaratchiServiceProvider as LaratchiLaratchiServiceProvider;

class LaratchiServiceProvider extends LaratchiLaratchiServiceProvider
{
    /**
     * @inheritDoc
     */
    public function register(): void
    {
        parent::register();

        AuthService::$jsonApiResource = MeJsonApiResource::class;
    }
}
