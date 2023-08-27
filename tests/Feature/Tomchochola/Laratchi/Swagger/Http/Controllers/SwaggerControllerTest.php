<?php

declare(strict_types=1);

namespace Tests\Feature\Tomchochola\Laratchi\Swagger\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tomchochola\Laratchi\Support\Resolver;

class SwaggerControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider localeDataProvider
     */
    public function test_api_v1_spec(string $locale): void
    {
        $this->locale($locale);

        $query = [];

        $response = $this->get(Resolver::resolveUrlGenerator()->to('/api/v1/spec', $query));

        $response->assertOk();

        $response->assertViewIs('laratchi::swagger');
    }
}
