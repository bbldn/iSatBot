<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /** @var string[] */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];
}