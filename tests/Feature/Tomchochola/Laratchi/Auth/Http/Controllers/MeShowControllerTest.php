<?php

declare(strict_types=1);

namespace Tests\Feature\Tomchochola\Laratchi\Auth\Http\Controllers;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tomchochola\Laratchi\Auth\Http\Controllers\MeShowController;

class MeShowControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_his_profile(): void
    {
        $me = UserFactory::new()->createOne();

        \assert($me instanceof User);

        $response = $this->be($me, 'users')->get(resolveUrlFactory()->action(MeShowController::class));

        $response->assertOk();

        $this->assertJsonApiResponse($response, $this->jsonStructureMe(false), 0);
    }
}
