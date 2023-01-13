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

    /**
     * @dataProvider localeDataProvider
     */
    public function test_user_can_update_his_profile(string $locale): void
    {
        $this->locale($locale);

        $me = UserFactory::new()->createOne();
        $newMe = UserFactory::new()->makeOne();

        \assert($me instanceof User && $newMe instanceof User);

        $query = [];
        $data = [
            'email' => $newMe->getEmail(),
            'name' => $newMe->getName(),
            'locale' => $newMe->getLocale(),
        ];

        $response = $this->be($me, 'users')->post(resolveUrlFactory()->action(MeUpdateController::class, $query), $data);

        $response->assertOk();

        $this->validateJsonApiResponse($response, $this->jsonApiValidatorMe(false), []);
    }

    /**
     * @dataProvider localeDataProvider
     */
    public function test_user_can_update_to_duplicate_credentials_if_its_the_same_user(string $locale): void
    {
        $this->locale($locale);

        $me = UserFactory::new()->createOne();

        \assert($me instanceof User);

        $query = [];
        $data = [
            'email' => $me->getEmail(),
            'name' => $me->getName(),
            'locale' => $me->getLocale(),
        ];

        $response = $this->be($me, 'users')->post(resolveUrlFactory()->action(MeUpdateController::class, $query), $data);

        $response->assertOk();

        $this->validateJsonApiResponse($response, $this->jsonApiValidatorMe(false), []);
    }

    /**
     * @dataProvider localeDataProvider
     */
    public function test_user_can_not_update_to_duplicate_credentials(string $locale): void
    {
        $this->locale($locale);

        $me = UserFactory::new()->createOne();
        $newUser = UserFactory::new()->createOne();

        \assert($me instanceof User && $newUser instanceof User);

        $query = [];
        $data = [
            'email' => $newUser->getEmail(),
            'name' => $newUser->getName(),
            'locale' => $newUser->getLocale(),
        ];

        $response = $this->be($me, 'users')->post(resolveUrlFactory()->action(MeUpdateController::class, $query), $data);

        $this->validateJsonApiValidationError($response, ['email']);
    }
}
