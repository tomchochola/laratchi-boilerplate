<?php

declare(strict_types=1);

namespace Tests\Feature\Tomchochola\Laratchi\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tomchochola\Laratchi\Support\Resolver;
use Tomchochola\Laratchi\Translation\Trans;

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

        $response = $this->get(Resolver::resolveUrlGenerator()->to('/', $query));

        $response->assertRedirect(Trans::inject()->assertString('spa.url'));
    }
}
