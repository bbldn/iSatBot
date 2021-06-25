<?php

namespace App\Console;

use App\Console\Commands\TinkerCommand;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /** @psalm-var list<class-string> */
    protected $commands = [
        TinkerCommand::class,
    ];
}