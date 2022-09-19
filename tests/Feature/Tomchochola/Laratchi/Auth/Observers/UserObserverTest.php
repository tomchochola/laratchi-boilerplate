<?php

declare(strict_types=1);

namespace Tests\Feature\Tomchochola\Laratchi\Auth\Observers;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Tomchochola\Laratchi\Auth\Notifications\PasswordInitNotification;

class UserObserverTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_gets_password_init_notification_after_creation(): void
    {
        Notification::fake();

        $me = UserFactory::new()->createOne([
            'password' => null,
        ]);

        \assert($me instanceof User);

        Notification::assertSentToTimes($me, PasswordInitNotification::class);
    }
}
