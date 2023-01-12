<?php

declare(strict_types=1);

namespace App\Console;

use Tomchochola\Laratchi\Console\Kernel as LaratchiKernel;

class Kernel extends LaratchiKernel
{
    public const SCHEDULE_TIMEZONE = 'UTC';
}
