<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Tomchochola\Laratchi\Support\ServiceProvider as LaratchiServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @inheritDoc
     */
    public function register(): void
    {
        parent::register();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        LaratchiServiceProvider::modelRestrictions();
    }
}
