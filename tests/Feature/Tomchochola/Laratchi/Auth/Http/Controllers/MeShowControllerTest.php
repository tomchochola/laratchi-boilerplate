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

    /**
     * @dataProvider localeDataProvider
     */
    public function test_user_can_view_his_profile(string $locale): void
    {
        $this->locale($locale);

        $me = UserFactory::new()->locale($locale)->createOne();

        \assert($me instanceof User);

        $query = [];

        $response = $this->be($me, 'users')->get(resolveUrlFactory()->action(MeShowController::class, $query));

        $response->assertOk();

        $this->validateJsonApiResponse($response, $this->structureMe(), []);
    }

    /**
     * @dataProvider localeDataProvider
     */
    public function test_guest_user_gets_no_content(string $locale): void
    {
        $this->locale($locale);

        $query = [];

        $response = $this->get(resolveUrlFactory()->action(MeShowController::class, $query));

        $response->assertNoContent();
    }
}
