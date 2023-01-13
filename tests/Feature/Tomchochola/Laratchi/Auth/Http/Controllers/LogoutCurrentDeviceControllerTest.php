<?php

declare(strict_types=1);

namespace Tests\Feature\Tomchochola\Laratchi\Auth\Http\Controllers;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Auth\Events\CurrentDeviceLogout;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use Tomchochola\Laratchi\Auth\Http\Controllers\LogoutCurrentDeviceController;

class LogoutCurrentDeviceControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider localeDataProvider
     */
    public function test_user_can_logout_on_current_device(string $locale): void
    {
        $this->locale($locale);

        Event::fake([CurrentDeviceLogout::class]);

        $me = UserFactory::new()->createOne();

        \assert($me instanceof User);

        $query = [];
        $data = [];

        $response = $this->be($me, 'users')->post(resolveUrlFactory()->action(LogoutCurrentDeviceController::class, $query), $data);

        $response->assertNoContent();

        $this->assertGuest('users');

        Event::assertDispatchedTimes(CurrentDeviceLogout::class);
    }
}
