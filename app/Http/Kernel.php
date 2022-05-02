<?php

declare(strict_types=1);

namespace App\Http;

use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\TrimStrings;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Auth\Middleware\RequirePassword;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;
use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance;
use Illuminate\Foundation\Http\Middleware\ValidatePostSize;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Http\Middleware\SetCacheHeaders;
use Illuminate\Http\Middleware\TrustProxies;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Routing\Middleware\ValidateSignature;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Tomchochola\Laratchi\Http\Middleware\SetPreferredLanguageMiddleware;
use Tomchochola\Laratchi\Http\Middleware\SetRequestFormatMiddleware;
use Tomchochola\Laratchi\Http\Middleware\ValidateAcceptHeaderMiddleware;
use Tomchochola\Laratchi\Http\Middleware\ValidateContentTypeHeaderMiddleware;

class Kernel extends HttpKernel
{
    /**
     * @inheritDoc
     *
     * @var array<mixed>
     */
    protected $middleware = [
        SetPreferredLanguageMiddleware::class.':en',
        TrustProxies::class,
        HandleCors::class,
        PreventRequestsDuringMaintenance::class,
        ValidatePostSize::class,
        TrimStrings::class,
        ConvertEmptyStringsToNull::class,
        AddQueuedCookiesToResponse::class,
    ];

    /**
     * @inheritDoc
     *
     * @var array<mixed>
     */
    protected $middlewareGroups = [
        'web' => [
            StartSession::class,
            ShareErrorsFromSession::class,
            VerifyCsrfToken::class,
        ],

        'api' => [
            SetRequestFormatMiddleware::class.':json',
            ValidateAcceptHeaderMiddleware::class.':application/json',
            ValidateContentTypeHeaderMiddleware::class.':json,form',
        ],
    ];

    /**
     * @inheritDoc
     *
     * @var array<mixed>
     */
    protected $routeMiddleware = [
        'auth' => Authenticate::class,
        'auth.basic' => AuthenticateWithBasicAuth::class,
        'auth.session' => AuthenticateSession::class,
        'cache.headers' => SetCacheHeaders::class,
        'can' => Authorize::class,
        'guest' => RedirectIfAuthenticated::class,
        'password.confirm' => RequirePassword::class,
        'signed' => ValidateSignature::class,
        'throttle' => ThrottleRequests::class,
        'verified' => EnsureEmailIsVerified::class,
    ];
}
