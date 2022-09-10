<?php

declare(strict_types=1);

namespace Tests;

use Tomchochola\Laratchi\Testing\TestCase as LaratchiTestCase;

abstract class TestCase extends LaratchiTestCase
{
    use CreatesApplication;
}
