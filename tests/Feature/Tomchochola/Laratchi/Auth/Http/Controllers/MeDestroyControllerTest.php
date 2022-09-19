<?php

declare(strict_types=1);

namespace Tests\Feature\Tomchochola\Laratchi\Auth\Http\Controllers;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tomchochola\Laratchi\Auth\Http\Controllers\MeDestroyController;

class MeDestroyControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_delete_his_account(): void
    {
        $me = UserFactory::new()->createOne();

        \assert($me instanceof User);

        $response = $this->be($me, 'users')->post(resolveUrlFactory()->action(inject(MeDestroyController::class)::class));

        $response->assertNoContent();
    }
}
