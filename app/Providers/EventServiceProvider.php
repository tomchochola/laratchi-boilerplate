<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\User;
use Tomchochola\Laratchi\Auth\Observers\UserObserver as LaratchiUserObserver;
use Tomchochola\Laratchi\Providers\EventServiceProvider as LaratchiEventServiceProvider;

class EventServiceProvider extends LaratchiEventServiceProvider
{
    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        parent::boot();

        User::observe([LaratchiUserObserver::class]);
    }
}
