<?php

declare(strict_types=1);

namespace Tests\Feature\Tomchochola\Laratchi\Auth\Http\Controllers;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tomchochola\Laratchi\Auth\Http\Controllers\LoginController;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider localeDataProvider
     */
    public function test_user_can_login(string $locale): void
    {
        $this->locale($locale);

        $me = UserFactory::new()->password()->createOne();

        \assert($me instanceof User);

        $data = [
            'email' => $me->getEmail(),
            'password' => UserFactory::PASSWORD,
        ];

        $response = $this->post(resolveUrlFactory()->action(LoginController::class), $data);

        $response->assertOk();

        $response->assertCookie(resolveGuard($me->getTable())->cookieName());

        $this->validateJsonApiResponse($response, $this->structureMe(), []);

        $this->assertAuthenticatedAs($me);
    }
}
