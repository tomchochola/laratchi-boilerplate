<?php

declare(strict_types=1);

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Tomchochola\Laratchi\Console\Kernel as LaratchiKernel;

class Kernel extends LaratchiKernel
{
    /**
     * @inheritDoc
     */
    protected function schedule(Schedule $schedule): void
    {
        parent::schedule($schedule);
    }
}
