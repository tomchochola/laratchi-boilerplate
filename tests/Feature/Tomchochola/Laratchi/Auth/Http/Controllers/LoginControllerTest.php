<?php

declare(strict_types=1);

namespace Tests\Feature\Tomchochola\Laratchi\Auth\Http\Controllers;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Auth\Events\Attempting;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Validated;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use Tomchochola\Laratchi\Auth\Http\Controllers\LoginController;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login(): void
    {
        Event::fake([Attempting::class, Validated::class, Login::class, Authenticated::class]);

        $me = UserFactory::new()->withValidPassword()->createOne();

        \assert($me instanceof User);

        $response = $this->post(resolveUrlFactory()->action(LoginController::class), [
            'email' => $me->getEmail(),
            'password' => UserFactory::VALID_PASSWORD,
            'remember' => true,
        ]);

        $response->assertOk();

        $this->validateJsonApiResponse($response, $this->jsonApiValidatorMe(true), [$this->jsonApiValidatorDatabaseToken()]);

        $this->assertAuthenticatedAs($me, 'users');

        Event::assertDispatchedTimes(Attempting::class);
        Event::assertDispatchedTimes(Validated::class);
        Event::assertDispatchedTimes(Login::class);
        Event::assertDispatchedTimes(Authenticated::class);
    }
}
