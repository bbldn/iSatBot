<?php

namespace App\Console;

use App\Services\TelegramService;
use Illuminate\Console\Command;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramCommand extends Command
{
    /** @var string $name */
    protected $name = 'telegram';

    /** @var TelegramService $telegramService */
    protected $telegramService;

    /**
     * TelegramCommand constructor.
     * @param TelegramService $telegramService
     */
    public function __construct(TelegramService $telegramService)
    {
        $this->telegramService = $telegramService;
        parent::__construct();
    }

    /**
     *
     */
    public function handle()
    {
        while (1) {
            $updates = Telegram::getUpdates();
            foreach ($updates as $update) {
                $this->telegramService->handle($update);
            }
            sleep(1);
        }
    }
}
