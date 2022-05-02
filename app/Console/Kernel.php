<?php

declare(strict_types=1);

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * @inheritDoc
     */
    protected function schedule(Schedule $schedule): void
    {
        parent::schedule($schedule);

        foreach (mustConfigArray('auth.passwords') as $brokerName => $config) {
            $schedule->command("auth:clear-resets {$brokerName}")->dailyAt('04:00')->withoutOverlapping()->runInBackground();
        }
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
