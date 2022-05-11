<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * @inheritDoc
     */
    protected $policies = [];

    /**
     * @inheritDoc
     */
    public function register(): void
    {
        parent::register();

        // Override password default validation
        // \Illuminate\Validation\Rules\Password::defaults(\Illuminate\Validation\Rules\Password::min(6));
    }

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
