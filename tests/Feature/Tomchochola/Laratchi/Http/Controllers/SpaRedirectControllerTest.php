<?php

declare(strict_types=1);

namespace Tests\Feature\Tomchochola\Laratchi\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SpaRedirectControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider localeDataProvider
     */
    public function test_index_path_not_throwing(string $locale): void
    {
        $this->locale($locale);

        $query = [];

        $response = $this->get(resolveUrlFactory()->to('/', $query));

        $spa = mustTransString('spa.url');

        static::assertNotSame($spa, mustConfigString('app.url'));

        $response->assertRedirect($spa);
    }
}
