<?php

declare(strict_types=1);

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Tomchochola\Laratchi\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * @inheritDoc
     */
    protected function schedule(Schedule $schedule): void
    {
        parent::schedule($schedule);
    }

    /**
     * @inheritDoc
     */
    protected function commands(): void
    {
        parent::commands();

        $this->load(__DIR__.'/Commands');

        require resolveApp()->basePath('routes/console.php');
    }
}
