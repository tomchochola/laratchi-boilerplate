<?php

declare(strict_types=1);

namespace Tests\Feature\Tomchochola\Laratchi\Auth\Http\Controllers;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Tomchochola\Laratchi\Auth\Notifications\EmailConfirmationNotification;
use Tomchochola\Laratchi\Auth\Services\EmailBrokerService;
use Tomchochola\Laratchi\Support\Resolver;
use Tomchochola\Laratchi\Support\Typer;

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

        $me = Typer::assertInstance(UserFactory::new()->makeOne(), User::class);

        $data = [
            'email' => $me->getEmail(),
            'locale' => $me->getLocale(),
            'password' => UserFactory::PASSWORD,
        ];

        $response = $this->post(Resolver::resolveUrlGenerator()->to('/api/v1/auth/register'), $data);

        $response->assertNoContent(202);

        $response->assertCookieMissing(Resolver::resolveDatabaseTokenGuard($me->getTable())->cookieName());

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

        $me = Typer::assertInstance(UserFactory::new()->makeOne(), User::class);

        $data = [
            'email' => $me->getEmail(),
            'locale' => $me->getLocale(),
            'password' => UserFactory::PASSWORD,
        ];

        EmailBrokerService::inject()->confirm($me->getTable(), $me->getEmail());

        $response = $this->post(Resolver::resolveUrlGenerator()->to('/api/v1/auth/register'), $data);

        $response->assertOk();

        $response->assertCookie(Resolver::resolveDatabaseTokenGuard($me->getTable())->cookieName());

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

        $me = Typer::assertInstance(UserFactory::new()->createOne(), User::class);

        $data = [
            'email' => $me->getEmail(),
            'locale' => $me->getLocale(),
            'password' => UserFactory::PASSWORD,
        ];

        $response = $this->post(Resolver::resolveUrlGenerator()->to('/api/v1/auth/register'), $data);

        $response->assertCookieMissing(Resolver::resolveDatabaseTokenGuard($me->getTable())->cookieName());

        $this->validateJsonApiValidationError($response, ['email']);

        $this->assertGuest();

        Notification::assertNothingSent();
    }
}
