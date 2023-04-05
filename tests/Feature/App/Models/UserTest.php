<?php

declare(strict_types=1);

namespace Tests\Feature\App\Models;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Tests\TestCase;
use Tomchochola\Laratchi\Auth\Notifications\PasswordInitNotification;
use Tomchochola\Laratchi\Auth\Notifications\ResetPasswordNotification;
use Tomchochola\Laratchi\Auth\Notifications\VerifyEmailNotification;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider localeBoolDataProvider
     */
    public function test_sending_password_init_notification(string $locale, bool $fake): void
    {
        $this->locale($locale);

        if ($fake) {
            Notification::fake();
        }

        $me = UserFactory::new()->locale($locale)->createOne();

        \assert($me instanceof User);

        $me->setAttribute('password', null);

        $me->sendPasswordResetNotification(Str::random());

        if ($fake) {
            Notification::assertSentToTimes($me, PasswordInitNotification::class);
        }
    }

    /**
     * @dataProvider localeBoolDataProvider
     */
    public function test_sending_password_reset_notification(string $locale, bool $fake): void
    {
        $this->locale($locale);

        if ($fake) {
            Notification::fake();
        }

        $me = UserFactory::new()->locale($locale)->createOne();

        \assert($me instanceof User);

        $me->sendPasswordResetNotification(Str::random());

        if ($fake) {
            Notification::assertSentToTimes($me, ResetPasswordNotification::class);
        }
    }

    /**
     * @dataProvider localeBoolDataProvider
     */
    public function test_sending_verify_email_notification(string $locale, bool $fake): void
    {
        $this->locale($locale);

        if ($fake) {
            Notification::fake();
        }

        $me = UserFactory::new()->locale($locale)->createOne();

        \assert($me instanceof User);

        $me->sendEmailVerificationNotification();

        if ($fake) {
            Notification::assertSentToTimes($me, VerifyEmailNotification::class);
        }
    }
}
