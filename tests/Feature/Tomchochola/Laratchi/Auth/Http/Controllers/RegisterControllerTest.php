<?php

declare(strict_types=1);

namespace Tests\Feature\Tomchochola\Laratchi\Auth\Http\Controllers;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Tomchochola\Laratchi\Auth\Http\Controllers\RegisterController;
use Tomchochola\Laratchi\Auth\Notifications\EmailConfirmationNotification;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider localeDataProvider
     */
    public function test_send_email_confirmation(string $locale): void
    {
        $this->locale($locale);

        Notification::fake();

        $me = UserFactory::new()->makeOne();

        \assert($me instanceof User);

        $query = [];
        $data = [
            'email' => $me->getEmail(),
            'locale' => $me->getLocale(),
        ];

        $response = $this->post(resolveUrlFactory()->action(RegisterController::class, $query), $data);

        $response->assertNoContent(202);

        $response->assertCookieMissing(resolveGuard($me->getTable())->cookieName());

        $this->assertGuest();

        Notification::assertSentToTimes((new AnonymousNotifiable())->route('mail', $me->getEmail()), EmailConfirmationNotification::class);
    }

    /**
     * @dataProvider localeDataProvider
     */
    public function test_user_can_register(string $locale): void
    {
        $this->locale($locale);

        Notification::fake();

        $me = UserFactory::new()->makeOne();

        \assert($me instanceof User);

        $query = [];
        $data = [
            'email' => $me->getEmail(),
            'token' => '111111',
            'name' => $me->getName(),
            'locale' => $me->getLocale(),
            'password' => UserFactory::PASSWORD,
        ];

        $response = $this->post(resolveUrlFactory()->action(RegisterController::class, $query), $data);

        $response->assertOk();

        $response->assertCookie(resolveGuard($me->getTable())->cookieName());

        $this->validateJsonApiResponse($response, $this->structureMe(), []);

        $this->assertAuthenticated();

        Notification::assertNothingSent();
    }

    /**
     * @dataProvider localeDataProvider
     */
    public function test_user_can_not_register_with_duplicate_credentials(string $locale): void
    {
        $this->locale($locale);

        Notification::fake();

        $me = UserFactory::new()->createOne();

        \assert($me instanceof User);

        $query = [];
        $data = [
            'email' => $me->getEmail(),
            'name' => $me->getName(),
            'locale' => $me->getLocale(),
            'password' => UserFactory::PASSWORD,
            'token' => '111111',
        ];

        $response = $this->post(resolveUrlFactory()->action(RegisterController::class, $query), $data);

        $response->assertCookieMissing(resolveGuard($me->getTable())->cookieName());

        $this->validateJsonApiValidationError($response, ['email']);

        $this->assertGuest();

        Notification::assertNothingSent();
    }
}
