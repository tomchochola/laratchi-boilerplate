<?php

declare(strict_types=1);

namespace Tests\Feature\Tomchochola\Laratchi\Auth\Notifications;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\AnonymousNotifiable;
use Tests\TestCase;
use Tomchochola\Laratchi\Auth\Notifications\PasswordResetNotification;
use Tomchochola\Laratchi\Config\Config;

class PasswordResetNotificationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider localeDataProvider
     */
    public function test_sending_notification(string $locale): void
    {
        $this->locale($locale);

        $email = \fake()->email();

        foreach (Config::inject()->authGuards() as $guard) {
            $notification = PasswordResetNotification::inject($guard, 'token', $email);

            (new AnonymousNotifiable())->route('mail', $email)->notify($notification->locale($locale));
        }
    }
}
