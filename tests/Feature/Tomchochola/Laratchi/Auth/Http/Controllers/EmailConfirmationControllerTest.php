<?php

declare(strict_types=1);

namespace Tests\Feature\Tomchochola\Laratchi\Auth\Http\Controllers;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tomchochola\Laratchi\Auth\Services\EmailBrokerService;
use Tomchochola\Laratchi\Support\Resolver;
use Tomchochola\Laratchi\Support\Typer;

class EmailConfirmationControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider localeDataProvider
     */
    public function test_user_can_confirm_email_from_notification(string $locale): void
    {
        $this->locale($locale);

        $me = Typer::assertInstance(UserFactory::new()->makeOne(), User::class);

        $data = [
            'email' => $me->getEmailForVerification(),
            'token' => EmailBrokerService::inject()->store($me->getTable(), $me->getEmailForVerification()),
        ];

        $response = $this->post(Resolver::resolveUrlGenerator()->to('/api/v1/email_verification/confirm'), $data);

        $response->assertNoContent();
    }

    /**
     * @dataProvider localeDataProvider
     */
    public function test_user_can_not_confirm_email_from_notification_if_already_verified(string $locale): void
    {
        $this->locale($locale);

        $me = Typer::assertInstance(UserFactory::new()->makeOne(), User::class);

        $data = [
            'email' => $me->getEmailForVerification(),
            'token' => '111111',
        ];

        EmailBrokerService::inject()->confirm($me->getTable(), $me->getEmailForVerification());

        $response = $this->be($me)->post(Resolver::resolveUrlGenerator()->to('/api/v1/email_verification/confirm'), $data);

        $this->validateJsonApiError($response, 409);
    }
}
