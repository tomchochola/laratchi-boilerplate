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

        $response->assertRedirect(mustTransString('spa.url'));
    }
}
