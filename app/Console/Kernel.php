<?php

namespace App\Console;

use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /** @psalm-var list<class-string> */
    protected $commands = [
        TelegramCommand::class,
        SendOrderCommand::class,
        SendBackupCommand::class,
        SendMessageCommand::class,
        SendCheaperMessage::class,
    ];

    /**
     * @return void
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        /** @noinspection PhpIncludeInspection */
        require base_path('routes/console.php');
    }
}