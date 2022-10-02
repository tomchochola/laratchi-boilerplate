<?php

declare(strict_types=1);

namespace Tests\Feature\Tomchochola\Laratchi\Auth\Http\Controllers;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tomchochola\Laratchi\Auth\Http\Controllers\MeUpdateController;

class MeUpdateControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_update_his_profile(): void
    {
        $me = UserFactory::new()->createOne();
        $newMe = UserFactory::new()->makeOne();

        \assert($me instanceof User && $newMe instanceof User);

        $response = $this->be($me, 'users')->post(resolveUrlFactory()->action(MeUpdateController::class), [
            'email' => $newMe->getEmail(),
            'name' => $newMe->getName(),
            'locale' => $newMe->getLocale(),
        ]);

        $response->assertOk();

        $this->assertJsonApiResponse($response, $this->jsonStructureMe(false), 0);
    }

    public function test_user_can_not_update_to_duplicate_credentials(): void
    {
        $me = UserFactory::new()->createOne();

        \assert($me instanceof User);

        $response = $this->be($me, 'users')->post(resolveUrlFactory()->action(MeUpdateController::class), [
            'email' => $me->getEmail(),
            'name' => $me->getName(),
            'locale' => $me->getLocale(),
        ]);

        $this->assertJsonValidationError($response, ['email']);
    }
}
