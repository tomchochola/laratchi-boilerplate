<?php

declare(strict_types=1);

namespace Tests\Feature\Tomchochola\Laratchi\Auth\Http\Controllers;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Tomchochola\Laratchi\Auth\Http\Controllers\MeUpdateController;
use Tomchochola\Laratchi\Auth\Notifications\EmailConfirmationNotification;
use Tomchochola\Laratchi\Auth\Services\EmailBrokerService;

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

        $me = UserFactory::new()->createOne();
        $newMe = UserFactory::new()->makeOne();

        \assert($me instanceof User && $newMe instanceof User);

        $data = [
            'email' => $newMe->getEmail(),
            'name' => $newMe->getName(),
            'locale' => $newMe->getLocale(),
        ];

        $response = $this->be($me)->post(resolveUrlFactory()->action(MeUpdateController::class), $data);

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

        $me = UserFactory::new()->createOne();
        $newMe = UserFactory::new()->makeOne();

        \assert($me instanceof User && $newMe instanceof User);

        $data = [
            'email' => $newMe->getEmail(),
            'name' => $newMe->getName(),
            'locale' => $newMe->getLocale(),
        ];

        EmailBrokerService::inject()->confirm($me->getTable(), $newMe->getEmail());

        $response = $this->be($me)->post(resolveUrlFactory()->action(MeUpdateController::class), $data);

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

        $me = UserFactory::new()->createOne();

        \assert($me instanceof User);

        $data = [
            'email' => $me->getEmail(),
            'name' => $me->getName(),
            'locale' => $me->getLocale(),
        ];

        EmailBrokerService::inject()->confirm($me->getTable(), $me->getEmail());

        $response = $this->be($me)->post(resolveUrlFactory()->action(MeUpdateController::class), $data);

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

        $me = UserFactory::new()->createOne();
        $newMe = UserFactory::new()->createOne();

        \assert($me instanceof User && $newMe instanceof User);

        $data = [
            'email' => $newMe->getEmail(),
            'name' => $newMe->getName(),
            'locale' => $newMe->getLocale(),
        ];

        $response = $this->be($me)->post(resolveUrlFactory()->action(MeUpdateController::class), $data);

        $this->validateJsonApiValidationError($response, ['email']);

        Notification::assertNothingSent();
    }
}
