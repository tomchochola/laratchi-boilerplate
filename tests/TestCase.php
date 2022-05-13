<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Storage;
use Tomchochola\Laratchi\Testing\TestingHelpersTraits;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use TestingHelpersTraits;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    /**
     * Locale data provider.
     *
     * @return array<string, array{string}>
     */
    public function localeDataProvider(): array
    {
        return [
            'en' => [
                'en',
            ],
        ];
    }
}
