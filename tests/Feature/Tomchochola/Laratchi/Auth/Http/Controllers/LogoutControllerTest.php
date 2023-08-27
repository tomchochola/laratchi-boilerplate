<?php

declare(strict_types=1);

namespace Tests\Feature\Tomchochola\Laratchi\Auth\Http\Controllers;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tomchochola\Laratchi\Support\Resolver;
use Tomchochola\Laratchi\Support\Typer;

class LogoutControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider localeDataProvider
     */
    public function test_user_can_logout(string $locale): void
    {
        $this->locale($locale);

        $me = Typer::assertInstance(UserFactory::new()->createOne(), User::class);

        $data = [];

        $response = $this->be($me)->post(Resolver::resolveUrlGenerator()->to('/api/v1/auth/logout'), $data);

        $response->assertNoContent();

        $response->assertCookieExpired(Resolver::resolveDatabaseTokenGuard($me->getTable())->cookieName());

        $this->assertGuest();
    }
}
