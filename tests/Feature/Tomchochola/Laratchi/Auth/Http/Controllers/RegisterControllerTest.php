<?php

declare(strict_types=1);

namespace Tests\Feature\Tomchochola\Laratchi\Auth\Http\Controllers;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use Tomchochola\Laratchi\Auth\Http\Controllers\RegisterController;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider localeDataProvider
     */
    public function test_user_can_register(string $locale): void
    {
        $this->locale($locale);

        Event::fake([Registered::class, Login::class, Authenticated::class]);

        $me = UserFactory::new()->makeOne();

        \assert($me instanceof User);

        $query = [];
        $data = [
            'email' => $me->getEmail(),
            'name' => $me->getName(),
            'locale' => $me->getLocale(),
            'password' => UserFactory::VALID_PASSWORD,
            'password_confirmation' => UserFactory::VALID_PASSWORD,
        ];

        $response = $this->post(resolveUrlFactory()->action(RegisterController::class, $query), $data);

        $response->assertCreated();

        $this->validateJsonApiResponse($response, $this->jsonApiValidatorMe(false), []);

        $me = User::query()->sole();

        \assert($me instanceof User);

        $this->assertAuthenticatedAs($me, 'users');

        Event::assertDispatchedTimes(Registered::class);
        Event::assertDispatchedTimes(Login::class);
        Event::assertDispatchedTimes(Authenticated::class);
    }

    /**
     * @dataProvider localeDataProvider
     */
    public function test_user_can_not_register_with_duplicate_credentials(string $locale): void
    {
        $this->locale($locale);

        Event::fake([Registered::class, Login::class, Authenticated::class]);

        $me = UserFactory::new()->createOne();

        \assert($me instanceof User);

        $query = [];
        $data = [
            'email' => $me->getEmail(),
            'name' => $me->getName(),
            'locale' => $me->getLocale(),
            'password' => UserFactory::VALID_PASSWORD,
            'password_confirmation' => UserFactory::VALID_PASSWORD,
        ];

        $response = $this->post(resolveUrlFactory()->action(RegisterController::class, $query), $data);

        $this->validateJsonApiValidationError($response, ['email']);

        $this->assertGuest('users');

        Event::assertNotDispatched(Registered::class);
        Event::assertNotDispatched(Login::class);
        Event::assertNotDispatched(Authenticated::class);
    }
}
