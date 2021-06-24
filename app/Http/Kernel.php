<?php

namespace App\Http;

use Fruitcake\Cors\HandleCors;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Auth\Middleware\RequirePassword;
use Illuminate\Http\Middleware\SetCacheHeaders;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Routing\Middleware\ValidateSignature;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Foundation\Http\Middleware\ValidatePostSize;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;

class Kernel extends HttpKernel
{
    /** @psalm-var list<class-string> */
    protected $middleware = [
        HandleCors::class,
        ValidatePostSize::class,
        ConvertEmptyStringsToNull::class,
    ];

    /**
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            StartSession::class,
            SubstituteBindings::class,
            ShareErrorsFromSession::class,
            AddQueuedCookiesToResponse::class,
        ],

        'api' => [
            'throttle:60,1',
            SubstituteBindings::class,
        ],
    ];

    /** @psalm-var array<string, class-string> */
    protected $routeMiddleware = [
        'can' => Authorize::class,
        'signed' => ValidateSignature::class,
        'throttle' => ThrottleRequests::class,
        'bindings' => SubstituteBindings::class,
        'cache.headers' => SetCacheHeaders::class,
        'verified' => EnsureEmailIsVerified::class,
        'password.confirm' => RequirePassword::class,
        'auth.basic' => AuthenticateWithBasicAuth::class,
    ];
}