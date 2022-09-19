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

    public function test_user_can_logout_on_current_device(): void
    {
        Event::fake([CurrentDeviceLogout::class]);

        $me = UserFactory::new()->createOne();

        \assert($me instanceof User);

        $response = $this->be($me, 'users')->post(resolveUrlFactory()->action(inject(LogoutCurrentDeviceController::class)::class));

        $response->assertNoContent();

        $this->assertGuest('users');

        Event::assertDispatchedTimes(CurrentDeviceLogout::class);
    }
}
