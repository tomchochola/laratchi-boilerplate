<?php

declare(strict_types=1);

namespace Tests\Feature\Tomchochola\Laratchi\Auth\Http\Controllers;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use Tomchochola\Laratchi\Auth\Notifications\VerifyEmailNotification;

class EmailVerificationVerifyControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_verify_email_from_notification(): void
    {
        Event::fake(Verified::class);

        $me = UserFactory::new()->unverified()->createOne();

        \assert($me instanceof User);

        $signedUrl = (new VerifyEmailNotification($me->getUserProviderName()))->signedUrl($me);

        $response = $this->be($me, 'users')->post($signedUrl);

        $response->assertNoContent();

        Event::assertDispatchedTimes(Verified::class);
    }

    public function test_user_can_verify_email_from_notification_as_guest(): void
    {
        Event::fake(Verified::class);

        $me = UserFactory::new()->unverified()->createOne();

        \assert($me instanceof User);

        $signedUrl = (new VerifyEmailNotification($me->getUserProviderName()))->signedUrl($me);

        $response = $this->post($signedUrl);

        $response->assertNoContent();

        Event::assertDispatchedTimes(Verified::class);
    }
}
