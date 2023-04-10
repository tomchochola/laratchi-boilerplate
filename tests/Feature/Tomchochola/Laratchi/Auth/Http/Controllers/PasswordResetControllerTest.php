<?php

declare(strict_types=1);

namespace Tests\Feature\Tomchochola\Laratchi\Auth\Http\Controllers;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

        $me = UserFactory::new()->createOne();

        \assert($me instanceof User);

        $token = resolvePasswordBroker($me->getTable())->createToken($me);

        $query = [];
        $data = [
            'email' => $me->getEmailForPasswordReset(),
            'token' => $token,
            'password' => UserFactory::PASSWORD,
        ];

        $response = $this->post(resolveUrlFactory()->action(PasswordResetController::class, $query), $data);

        $response->assertOk();

        $response->assertCookie(resolveGuard($me->getTable())->cookieName());

        $this->validateJsonApiResponse($response, $this->structureMe(), []);

        $this->assertAuthenticatedAs($me);
    }
}
