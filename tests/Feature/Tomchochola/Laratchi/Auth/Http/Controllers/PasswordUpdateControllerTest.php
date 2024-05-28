<?php

declare(strict_types=1);

namespace Tests\Feature\Tomchochola\Laratchi\Auth\Http\Controllers;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tomchochola\Laratchi\Support\Resolver;
use Tomchochola\Laratchi\Support\Typer;

class PasswordUpdateControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider localeDataProvider
     */
    public function test_user_can_update_his_password(string $locale): void
    {
        $this->locale($locale);

        $me = Typer::assertInstance(UserFactory::new()->password()->createOne(), User::class);

        $data = [
            'password' => UserFactory::PASSWORD,
            'new_password' => UserFactory::PASSWORD,
        ];

        $response = $this->be($me)->post(Resolver::resolveUrlGenerator()->to('/api/v1/password/update'), $data);

        $response->assertOk();

        $response->assertCookie(Resolver::resolveDatabaseTokenGuard($me->getTable())->cookieName());

        $this->validateJsonApiResponse($response, $this->structureMe(), []);

        $this->assertAuthenticatedAs($me);
    }
}
