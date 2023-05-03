<?php

declare(strict_types=1);

namespace Tests\Feature\Tomchochola\Laratchi\Auth\Http\Controllers;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tomchochola\Laratchi\Auth\Http\Controllers\EmailConfirmationController;
use Tomchochola\Laratchi\Auth\Services\EmailBrokerService;

class EmailConfirmationControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider localeDataProvider
     */
    public function test_user_can_confirm_email_from_notification(string $locale): void
    {
        $this->locale($locale);

        $me = UserFactory::new()->makeOne();

        \assert($me instanceof User);

        $data = [
            'email' => $me->getEmailForVerification(),
            'token' => EmailBrokerService::inject()->store($me->getTable(), $me->getEmailForVerification()),
        ];

        $response = $this->post(resolveUrlFactory()->action(EmailConfirmationController::class), $data);

        $response->assertNoContent();
    }

    /**
     * @dataProvider localeDataProvider
     */
    public function test_user_can_not_confirm_email_from_notification_if_already_verified(string $locale): void
    {
        $this->locale($locale);

        $me = UserFactory::new()->makeOne();

        \assert($me instanceof User);

        $data = [
            'email' => $me->getEmailForVerification(),
            'token' => '111111',
        ];

        EmailBrokerService::inject()->confirm($me->getTable(), $me->getEmailForVerification());

        $response = $this->be($me)->post(resolveUrlFactory()->action(EmailConfirmationController::class), $data);

        $this->validateJsonApiError($response, 409);
    }
}
