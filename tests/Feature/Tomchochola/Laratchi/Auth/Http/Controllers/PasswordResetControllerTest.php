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

    public function test_user_can_reset_password_from_email_link(): void
    {
        Event::fake([PasswordReset::class, Login::class, Authenticated::class]);

        $me = UserFactory::new()->createOne();

        \assert($me instanceof User);

        $broker = resolvePasswordBrokerManager()->broker($me->getPasswordBrokerName());

        \assert($broker instanceof PasswordBroker);

        $response = $this->post(resolveUrlFactory()->action(inject(PasswordResetController::class)::class), [
            'email' => $me->getEmailForPasswordReset(),
            'token' => $broker->createToken($me),
            'password' => UserFactory::VALID_PASSWORD,
            'password_confirmation' => UserFactory::VALID_PASSWORD,
        ]);

        $response->assertOk();

        $this->assertJsonApiResponse($response, $this->jsonStructureMe(true), 1, $this->jsonStructureDatabaseToken(true));

        $this->assertAuthenticatedAs($me, 'users');

        Event::assertDispatchedTimes(PasswordReset::class);
        Event::assertDispatchedTimes(Login::class);
        Event::assertDispatchedTimes(Authenticated::class);
    }
}
