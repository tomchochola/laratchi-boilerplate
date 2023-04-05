<?php

declare(strict_types=1);

namespace Tests\Feature\Tomchochola\Laratchi\Auth\Http\Controllers;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Tomchochola\Laratchi\Auth\Http\Controllers\PasswordForgotController;
use Tomchochola\Laratchi\Auth\Notifications\ResetPasswordNotification;

class PasswordForgotControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider localeDataProvider
     */
    public function test_user_can_request_password_reset_email(string $locale): void
    {
        $this->locale($locale);

        Notification::fake();

        $me = UserFactory::new()->locale($locale)->createOne();

        \assert($me instanceof User);

        $query = [];
        $data = [
            'email' => $me->getEmail(),
        ];

        $response = $this->post(resolveUrlFactory()->action(PasswordForgotController::class, $query), $data);

        $response->assertNoContent();

        Notification::assertSentToTimes($me, ResetPasswordNotification::class);
    }
}
