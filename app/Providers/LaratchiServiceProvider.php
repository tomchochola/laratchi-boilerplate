<?php

declare(strict_types=1);

namespace App\Providers;

use Tomchochola\Laratchi\Providers\LaratchiServiceProvider as LaratchiLaratchiServiceProvider;
use Tomchochola\Laratchi\Validation\SecureValidator;

class LaratchiServiceProvider extends LaratchiLaratchiServiceProvider
{
    /**
     * @inheritDoc
     */
    public function register(): void
    {
        parent::register();

        SecureValidator::$usePlaceholderAttributes = true;
    }
}
