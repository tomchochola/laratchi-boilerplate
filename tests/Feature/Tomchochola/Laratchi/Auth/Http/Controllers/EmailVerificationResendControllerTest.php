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

    public function test_user_can_request_another_email_verification(): void
    {
        Notification::fake();

        $me = UserFactory::new()->unverified()->createOne();

        \assert($me instanceof User);

        $response = $this->be($me, 'users')->post(resolveUrlFactory()->action(EmailVerificationResendController::class));

        $response->assertNoContent();

        Notification::assertSentToTimes($me, VerifyEmailNotification::class);
    }
}
