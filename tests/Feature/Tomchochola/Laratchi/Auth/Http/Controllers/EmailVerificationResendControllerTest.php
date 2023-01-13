<?php

declare(strict_types=1);

namespace Tests\Feature\Tomchochola\Laratchi\Auth\Http\Controllers;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Tomchochola\Laratchi\Auth\Http\Controllers\EmailVerificationResendController;
use Tomchochola\Laratchi\Auth\Notifications\VerifyEmailNotification;

class EmailVerificationResendControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider localeDataProvider
     */
    public function test_user_can_request_another_email_verification(string $locale): void
    {
        $this->locale($locale);

        Notification::fake();

        $me = UserFactory::new()->unverified()->createOne();

        \assert($me instanceof User);

        $query = [];
        $data = [];

        $response = $this->be($me, 'users')->post(resolveUrlFactory()->action(EmailVerificationResendController::class, $query), $data);

        $response->assertNoContent();

        Notification::assertSentToTimes($me, VerifyEmailNotification::class);
    }

    /**
     * @dataProvider localeDataProvider
     */
    public function test_user_can_request_another_email_verification_as_guest(string $locale): void
    {
        $this->locale($locale);

        Notification::fake();

        $me = UserFactory::new()->unverified()->createOne();

        \assert($me instanceof User);

        $query = [];
        $data = [
            'email' => $me->getEmailForVerification(),
        ];

        $response = $this->post(resolveUrlFactory()->action(EmailVerificationResendController::class, $query), $data);

        $response->assertNoContent();

        Notification::assertSentToTimes($me, VerifyEmailNotification::class);
    }
}
