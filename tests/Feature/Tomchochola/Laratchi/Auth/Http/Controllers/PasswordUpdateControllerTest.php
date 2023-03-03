<?php

declare(strict_types=1);

namespace Tests\Feature\Tomchochola\Laratchi\Auth\Http\Controllers;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Auth\Events\Validated;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use Tomchochola\Laratchi\Auth\Events\PasswordUpdateEvent;
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

        Event::fake([PasswordUpdateEvent::class, Validated::class]);

        $me = UserFactory::new()->withValidPassword()->createOne();

        \assert($me instanceof User);

        $query = [];
        $data = [
            'password' => UserFactory::VALID_PASSWORD,
            'new_password' => UserFactory::VALID_PASSWORD,
            'new_password_confirmation' => UserFactory::VALID_PASSWORD,
        ];

        $response = $this->be($me, 'users')->post(resolveUrlFactory()->action(PasswordUpdateController::class, $query), $data);

        $response->assertOk();

        $this->validateJsonApiResponse($response, $this->embedMe(), []);

        Event::assertDispatchedTimes(Validated::class);
        Event::assertDispatchedTimes(PasswordUpdateEvent::class);
    }
}
