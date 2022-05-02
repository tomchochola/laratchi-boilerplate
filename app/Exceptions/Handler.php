<?php

declare(strict_types=1);

namespace App\Exceptions;

use Tomchochola\Laratchi\Exceptions\Handler as BaseHandler;

class Handler extends BaseHandler
{
    /**
     * @inheritDoc
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
        'new_password',
        'new_password_confirmation',
    ];
}
