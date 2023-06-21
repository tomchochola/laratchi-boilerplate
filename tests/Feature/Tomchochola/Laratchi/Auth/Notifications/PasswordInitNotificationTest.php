<?php

declare(strict_types=1);

namespace Tests\Feature\Tomchochola\Laratchi\Auth\Notifications;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\AnonymousNotifiable;
use Tests\TestCase;
use Tomchochola\Laratchi\Auth\Notifications\PasswordInitNotification;

class PasswordInitNotificationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider localeDataProvider
     */
    public function test_sending_notification(string $locale): void
    {
        $this->locale($locale);

        $email = fake()->email();

        foreach (\array_keys(mustConfigArray('auth.guards')) as $guard) {
            $notification = PasswordInitNotification::inject((string) $guard, 'token', $email);

            (new AnonymousNotifiable())->route('mail', $email)->notify($notification->locale($locale));
        }
    }
}
