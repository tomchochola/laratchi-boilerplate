<?php

declare(strict_types=1);

namespace Tests\Feature\Tomchochola\Laratchi\Auth\Http\Controllers;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use Tomchochola\Laratchi\Auth\Http\Controllers\EmailVerificationVerifyController;
use Tomchochola\Laratchi\Auth\Notifications\VerifyEmailNotification;

class EmailVerificationVerifyControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider localeDataProvider
     */
    public function test_user_can_verify_email_from_notification(string $locale): void
    {
        $this->locale($locale);

        Event::fake(Verified::class);

        $me = UserFactory::new()->unverified()->locale($locale)->createOne();

        \assert($me instanceof User);

        $signedUrl = (new VerifyEmailNotification($me->getUserProviderName(), EmailVerificationVerifyController::class))->signedUrl($me);

        $data = [];

        $response = $this->be($me, 'users')->post($signedUrl, $data);

        $response->assertNoContent();

        Event::assertDispatchedTimes(Verified::class);
    }

    /**
     * @dataProvider localeDataProvider
     */
    public function test_user_can_verify_email_from_notification_as_guest(string $locale): void
    {
        $this->locale($locale);

        Event::fake(Verified::class);

        $me = UserFactory::new()->unverified()->locale($locale)->createOne();

        \assert($me instanceof User);

        $signedUrl = (new VerifyEmailNotification($me->getUserProviderName(), EmailVerificationVerifyController::class))->signedUrl($me);

        $data = [];

        $response = $this->post($signedUrl, $data);

        $response->assertNoContent();

        Event::assertDispatchedTimes(Verified::class);
    }
}
