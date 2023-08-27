<?php

declare(strict_types=1);

namespace Tests\Feature\Tomchochola\Laratchi\Auth\Http\Controllers;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Tomchochola\Laratchi\Auth\Notifications\PasswordResetNotification;
use Tomchochola\Laratchi\Support\Resolver;
use Tomchochola\Laratchi\Support\Typer;

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

        $me = Typer::assertInstance(UserFactory::new()->createOne(), User::class);

        $data = [
            'email' => $me->getEmail(),
        ];

        $response = $this->post(Resolver::resolveUrlGenerator()->to('/api/v1/password/forgot'), $data);

        $response->assertNoContent(202);

        Notification::assertSentToTimes($me, PasswordResetNotification::class);
    }
}
