<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TrimStrings as Middleware;

class TrimStrings extends Middleware
{
    /**
     * @inheritDoc
     *
     * @var array<mixed>
     */
    protected $except = [
        'current_password',
        'password',
        'password_confirmation',
        'new_password',
        'new_password_confirmation',
    ];
}
