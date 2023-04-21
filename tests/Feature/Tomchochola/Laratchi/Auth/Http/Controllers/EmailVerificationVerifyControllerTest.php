<?php

declare(strict_types=1);

namespace Tests\Feature\Tomchochola\Laratchi\Auth\Http\Controllers;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tomchochola\Laratchi\Auth\Http\Controllers\EmailVerificationVerifyController;

class EmailVerificationVerifyControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider localeDataProvider
     */
    public function test_user_can_verify_email_from_notification(string $locale): void
    {
        $this->locale($locale);

        $me = UserFactory::new()->unverified()->createOne();

        \assert($me instanceof User);

        $data = [
            'token' => '111111',
        ];

        $response = $this->be($me)->post(resolveUrlFactory()->action(EmailVerificationVerifyController::class), $data);

        $response->assertNoContent();
    }

    /**
     * @dataProvider localeDataProvider
     */
    public function test_user_can_verify_email_from_notification_as_guest(string $locale): void
    {
        $this->locale($locale);

        $me = UserFactory::new()->unverified()->createOne();

        \assert($me instanceof User);

        $this->assertDatabaseHas($me->getTable(), [
            'email_verified_at' => null,
        ]);

        $data = [
            'email' => $me->getEmailForVerification(),
            'token' => '111111',
        ];

        $response = $this->post(resolveUrlFactory()->action(EmailVerificationVerifyController::class), $data);

        $response->assertNoContent();
    }

    /**
     * @dataProvider localeDataProvider
     */
    public function test_user_can_not_verify_email_from_notification_if_already_verified(string $locale): void
    {
        $this->locale($locale);

        $me = UserFactory::new()->createOne();

        \assert($me instanceof User);

        $data = [
            'token' => '111111',
        ];

        $response = $this->be($me)->post(resolveUrlFactory()->action(EmailVerificationVerifyController::class), $data);

        $this->validateJsonApiError($response, 409);
    }
}
