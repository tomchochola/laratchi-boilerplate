<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Support\Arr;
use Tomchochola\Laratchi\Testing\TestCase as LaratchiTestCase;

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
     * Me json structure resource.
     *
     * @return array<mixed>
     */
    protected function jsonStructureMe(?bool $includeDatabaseToken): array
    {
        $structure = $this->jsonStructureResource([
            'email',
            'name',
            'locale',
            'email_verified_at',
        ]);

        if ($includeDatabaseToken !== false) {
            Arr::set($structure, 'relationships.database_token', $includeDatabaseToken === null ? ['data' => []] : $this->jsonStructureRelationship());
        }

        return $structure;
    }

    /**
     * Database token json structure resource.
     *
     * @return array<mixed>
     */
    protected function jsonStructureDatabaseToken(bool $includeBearer): array
    {
        return $this->jsonStructureResource($includeBearer ? [
            'auth_id',
            'provider',
            'bearer',
        ] : [
            'auth_id',
            'provider',
        ]);
    }
}
