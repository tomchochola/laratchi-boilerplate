<?php

declare(strict_types=1);

namespace Tests\Feature\Tomchochola\Laratchi\Auth\Http\Controllers;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Auth\Events\OtherDeviceLogout;
use Illuminate\Auth\Events\Validated;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use Tomchochola\Laratchi\Auth\Http\Controllers\LogoutOtherDevicesController;

class LogoutOtherDevicesControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider localeDataProvider
     */
    public function test_user_can_logout_on_other_devices(string $locale): void
    {
        $this->locale($locale);

        Event::fake([OtherDeviceLogout::class, Validated::class]);

        $me = UserFactory::new()->withValidPassword()->createOne();

        \assert($me instanceof User);

        $query = [];
        $data = [
            'password' => UserFactory::VALID_PASSWORD,
        ];

        $response = $this->be($me, 'users')->post(resolveUrlFactory()->action(LogoutOtherDevicesController::class, $query), $data);

        $response->assertOk();

        $this->validateJsonApiResponse($response, $this->structureMe(), []);

        $this->assertAuthenticatedAs($me, 'users');

        Event::assertDispatchedTimes(Validated::class);
        Event::assertDispatchedTimes(OtherDeviceLogout::class);
    }
}
