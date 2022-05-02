<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Tomchochola\Laratchi\Auth\Observers\UserObserver;

class EventServiceProvider extends ServiceProvider
{
    /**
     * @inheritDoc
     *
     * @var array<mixed>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        parent::boot();

        User::observe([UserObserver::class]);
    }
}
