<?php

declare(strict_types=1);

namespace Tests\Feature\Tomchochola\Laratchi\Auth\Notifications;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tomchochola\Laratchi\Auth\Notifications\ResetPasswordNotification;

class ResetPasswordNotificationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider localeDataProvider
     */
    public function test_sending_reset_password_notification(string $locale): void
    {
        $this->locale($locale);

        $me = UserFactory::new()->createOne();

        \assert($me instanceof User);

        $notification = new ResetPasswordNotification(fake()->randomAscii());
        $notification->locale($locale);

        $me->notify($notification);
    }
}
