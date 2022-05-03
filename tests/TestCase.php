<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tomchochola\Laratchi\Testing\TestingHelpersTraits;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use TestingHelpersTraits;
}
