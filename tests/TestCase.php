<?php

declare(strict_types=1);

namespace Tests;

use Tomchochola\Laratchi\Auth\Http\Validation\AuthValidity;
use Tomchochola\Laratchi\Testing\JsonApiValidator;
use Tomchochola\Laratchi\Testing\TestCase as LaratchiTestCase;

abstract class TestCase extends LaratchiTestCase
{
    use CreatesApplication;

    /**
     * @inheritDoc
     */
    public function localeDataProvider(): array
    {
        return [
            'cs' => [
                'cs',
            ],
            'en' => [
                'en',
            ],
        ];
    }

    /**
     * Me json api validator.
     */
    protected function jsonApiValidatorMe(): JsonApiValidator
    {
        $authValidity = inject(AuthValidity::class);

        return $this->jsonApiValidator('users', [
            'email' => $authValidity->email('users')->required(),
            'name' => $authValidity->name('users')->required(),
            'locale' => $authValidity->locale('users')->required(),
            'email_verified_at' => $authValidity->emailVerifiedAt('users')->nullable()->present(),
            'created_at' => $authValidity->createdAt('users')->required(),
            'updated_at' => $authValidity->updatedAt('users')->required(),
        ]);
    }
}
