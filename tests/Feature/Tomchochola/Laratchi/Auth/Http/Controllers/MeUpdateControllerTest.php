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

class MeUpdateControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider localeDataProvider
     */
    public function test_send_email_confirmation(string $locale): void
    {
        $this->locale($locale);

        Notification::fake();

        $me = Typer::assertInstance(UserFactory::new()->createOne(), User::class);
        $newMe = Typer::assertInstance(UserFactory::new()->makeOne(), User::class);

        $data = [
            'email' => $newMe->getEmail(),
            'locale' => $newMe->getLocale(),
        ];

        $response = $this->be($me)->post(Resolver::resolveUrlGenerator()->to('/api/v1/me/update'), $data);

        $response->assertNoContent(202);

        Notification::assertSentToTimes((new AnonymousNotifiable())->route('mail', $newMe->getEmail()), EmailConfirmationNotification::class);
    }

    /**
     * @dataProvider localeDataProvider
     */
    public function test_user_can_update_his_profile(string $locale): void
    {
        $this->locale($locale);

        Notification::fake();

        $me = Typer::assertInstance(UserFactory::new()->createOne(), User::class);
        $newMe = Typer::assertInstance(UserFactory::new()->makeOne(), User::class);

        $data = [
            'email' => $newMe->getEmail(),
            'locale' => $newMe->getLocale(),
        ];

        EmailBrokerService::inject()->confirm($me->getTable(), $newMe->getEmail());

        $response = $this->be($me)->post(Resolver::resolveUrlGenerator()->to('/api/v1/me/update'), $data);

        $response->assertNoContent();

        Notification::assertNothingSent();
    }

    /**
     * @dataProvider localeDataProvider
     */
    public function test_user_can_update_to_duplicate_credentials_if_its_the_same_user(string $locale): void
    {
        $this->locale($locale);

        Notification::fake();

        $me = Typer::assertInstance(UserFactory::new()->createOne(), User::class);

        $data = [
            'email' => $me->getEmail(),
            'locale' => $me->getLocale(),
        ];

        EmailBrokerService::inject()->confirm($me->getTable(), $me->getEmail());

        $response = $this->be($me)->post(Resolver::resolveUrlGenerator()->to('/api/v1/me/update'), $data);

        $response->assertNoContent();

        Notification::assertNothingSent();
    }

    /**
     * @dataProvider localeDataProvider
     */
    public function test_user_can_not_update_to_duplicate_credentials(string $locale): void
    {
        $this->locale($locale);

        Notification::fake();

        $me = Typer::assertInstance(UserFactory::new()->createOne(), User::class);
        $newMe = Typer::assertInstance(UserFactory::new()->createOne(), User::class);

        $data = [
            'email' => $newMe->getEmail(),
            'locale' => $newMe->getLocale(),
        ];

        $response = $this->be($me)->post(Resolver::resolveUrlGenerator()->to('/api/v1/me/update'), $data);

        $this->validateJsonApiValidationError($response, ['email']);

        Notification::assertNothingSent();
    }
}
