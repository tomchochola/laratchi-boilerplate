<?php

declare(strict_types=1);

namespace Tests\Feature\Tomchochola\Laratchi\Auth\Http\Controllers;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use Tomchochola\Laratchi\Auth\Http\Controllers\PasswordResetController;

class PasswordResetControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider localeDataProvider
     */
    public function test_user_can_reset_password_from_email_link(string $locale): void
    {
        $this->locale($locale);

        Event::fake([PasswordReset::class, Login::class, Authenticated::class]);

        $me = UserFactory::new()->createOne();

        \assert($me instanceof User);

        $broker = resolvePasswordBrokerManager()->broker($me->getPasswordBrokerName());

        \assert($broker instanceof PasswordBroker);

        $query = [];
        $data = [
            'email' => $me->getEmailForPasswordReset(),
            'token' => $broker->createToken($me),
            'password' => UserFactory::VALID_PASSWORD,
            'password_confirmation' => UserFactory::VALID_PASSWORD,
        ];

        $response = $this->post(resolveUrlFactory()->action(PasswordResetController::class, $query), $data);

        $response->assertOk();

        $this->validateJsonApiResponse($response, $this->jsonApiValidatorMe(false), []);

        $this->assertAuthenticatedAs($me, 'users');

        Event::assertDispatchedTimes(PasswordReset::class);
        Event::assertDispatchedTimes(Login::class);
        Event::assertDispatchedTimes(Authenticated::class);
    }
}
