<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Contracts\Console\Kernel as KernelContract;
use Symfony\Component\HttpKernel\HttpKernelInterface;

trait CreatesApplication
{
    /**
     * Creates the application.
     */
    public function createApplication(): HttpKernelInterface
    {
        $app = require __DIR__ . '/../bootstrap/app.php';

        $app->make(KernelContract::class)->bootstrap();

        return $app;
    }
}
