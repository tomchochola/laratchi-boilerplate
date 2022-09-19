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
use Tomchochola\Laratchi\Support\SignedUrlSupport;

class EmailVerificationVerifyControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_verify_email_from_notification(): void
    {
        Event::fake(Verified::class);

        $me = UserFactory::new()->unverified()->createOne();

        \assert($me instanceof User);

        $parameters = [
            'id' => $me->getAuthIdentifier(),
            'hash' => \hash('sha256', $me->getEmailForVerification()),
        ];

        $signedUrl = SignedUrlSupport::make(inject(EmailVerificationVerifyController::class)::class, $parameters, 0);

        $response = $this->be($me, 'users')->post($signedUrl);

        $response->assertNoContent();

        Event::assertDispatchedTimes(Verified::class);
    }
}
