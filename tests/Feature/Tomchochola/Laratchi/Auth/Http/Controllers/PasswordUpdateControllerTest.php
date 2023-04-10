<?php

declare(strict_types=1);

namespace Tests\Feature\Tomchochola\Laratchi\Auth\Http\Controllers;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tomchochola\Laratchi\Auth\Http\Controllers\PasswordUpdateController;

class PasswordUpdateControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider localeDataProvider
     */
    public function test_user_can_update_his_password(string $locale): void
    {
        $this->locale($locale);

        $me = UserFactory::new()->password()->createOne();

        \assert($me instanceof User);

        $query = [];
        $data = [
            'password' => UserFactory::PASSWORD,
            'new_password' => UserFactory::PASSWORD,
        ];

        $response = $this->be($me)->post(resolveUrlFactory()->action(PasswordUpdateController::class, $query), $data);

        $response->assertOk();

        $response->assertCookie(resolveGuard($me->getTable())->cookieName());

        $this->validateJsonApiResponse($response, $this->structureMe(), []);

        $this->assertAuthenticatedAs($me);
    }
}
