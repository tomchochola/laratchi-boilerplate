<?php

declare(strict_types=1);

namespace Tests\Feature\Tomchochola\Laratchi\Auth\Http\Controllers;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tomchochola\Laratchi\Support\Resolver;
use Tomchochola\Laratchi\Support\Typer;

class PasswordResetControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider localeDataProvider
     */
    public function test_user_can_reset_password_from_email_link(string $locale): void
    {
        $this->locale($locale);

        $me = Typer::assertInstance(UserFactory::new()->createOne(), User::class);

        $token = Resolver::resolvePasswordBroker($me->getTable())->createToken($me);

        $data = [
            'email' => $me->getEmailForPasswordReset(),
            'token' => $token,
            'password' => UserFactory::PASSWORD,
        ];

        $response = $this->post(Resolver::resolveUrlGenerator()->to('/api/v1/password/reset'), $data);

        $response->assertOk();

        $response->assertCookie(Resolver::resolveDatabaseTokenGuard($me->getTable())->cookieName());

        $this->validateJsonApiResponse($response, $this->structureMe(), []);

        $this->assertAuthenticatedAs($me);
    }
}
