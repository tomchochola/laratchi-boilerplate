<?php

declare(strict_types=1);

namespace App\Exceptions;

use Tomchochola\Laratchi\Exceptions\Handler as LaratchiHandler;

class Handler extends LaratchiHandler
{
    /**
     * @inheritDoc
     */
    public static bool $genericErrors = true;
}
