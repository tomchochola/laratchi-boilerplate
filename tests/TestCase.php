<?php

declare(strict_types=1);

namespace Tests;

use Tomchochola\Laratchi\Auth\Http\Validation\AuthValidity;
use Tomchochola\Laratchi\Testing\JsonApiValidator;
use Tomchochola\Laratchi\Testing\TestCase as LaratchiTestCase;
use Tomchochola\Laratchi\Validation\Validity;

abstract class TestCase extends LaratchiTestCase
{
    use CreatesApplication;

    /**
     * @inheritDoc
     */
    protected $defaultHeaders = [
        'Accept-Language' => 'cs',
    ];

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
    protected function jsonApiValidatorMe(?bool $includeDatabaseToken): JsonApiValidator
    {
        $authValidity = inject(AuthValidity::class);

        return $this->jsonApiValidator('users', [
            'email' => $authValidity->email('users')->required(),
            'name' => $authValidity->name('users')->required(),
            'locale' => $authValidity->locale('users')->required(),
            'email_verified_at' => Validity::make()->nullable()->raw()->date(),
        ])->relationship('database_token', $this->jsonApiValidatorDatabaseToken(), $includeDatabaseToken);
    }

    /**
     * Database token json api validator.
     */
    protected function jsonApiValidatorDatabaseToken(): JsonApiValidator
    {
        return $this->jsonApiValidator('database_tokens', [
            'auth_id' => Validity::make()->required()->raw(),
            'provider' => Validity::make()->required()->raw(),
            'bearer' => Validity::make()->nullable()->raw(),
        ]);
    }
}
