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
     * Locale data provider.
     *
     * @return array<mixed>
     */
    public static function localeDataProvider(): array
    {
        return [
            'en' => ['en'],
            'cs' => ['cs'],
        ];
    }

    /**
     * Structure Me.
     */
    protected function structureMe(): JsonApiValidator
    {
        $authValidity = AuthValidity::inject();

        return $this->structure('users', [
            'email' => $authValidity->email()->required(),
            'locale' => $authValidity->locale()->required(),
            'created_at' => $authValidity->createdAt()->required(),
            'updated_at' => $authValidity->updatedAt()->required(),
        ]);
    }

    /**
     * User embed structure.
     */
    protected function structureUserEmbed(): JsonApiValidator
    {
        return $this->structure('users', []);
    }
}
