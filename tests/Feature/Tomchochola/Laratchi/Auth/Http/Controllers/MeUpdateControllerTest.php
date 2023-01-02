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

        $this->validateJsonApiResponse($response, $this->jsonApiValidatorMe(false), []);
    }

    public function test_user_can_update_to_duplicate_credentials_if_its_the_same_user(): void
    {
        $me = UserFactory::new()->createOne();

        \assert($me instanceof User);

        $response = $this->be($me, 'users')->post(resolveUrlFactory()->action(MeUpdateController::class), [
            'email' => $me->getEmail(),
            'name' => $me->getName(),
            'locale' => $me->getLocale(),
        ]);

        $response->assertOk();

        $this->validateJsonApiResponse($response, $this->jsonApiValidatorMe(false), []);
    }

    public function test_user_can_not_update_to_duplicate_credentials(): void
    {
        $me = UserFactory::new()->createOne();
        $newUser = UserFactory::new()->createOne();

        \assert($me instanceof User && $newUser instanceof User);

        $response = $this->be($me, 'users')->post(resolveUrlFactory()->action(MeUpdateController::class), [
            'email' => $newUser->getEmail(),
            'name' => $newUser->getName(),
            'locale' => $newUser->getLocale(),
        ]);

        $this->assertJsonValidationError($response, ['email']);
    }
}
