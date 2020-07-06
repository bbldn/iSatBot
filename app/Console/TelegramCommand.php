<?php

namespace App\Console;

use App\Services\TelegramService;
use Illuminate\Console\Command;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Objects\Update;

class TelegramCommand extends Command
{
    /** @var string $name */
    protected $name = 'telegram:start';

    /** @var string $description */
    protected $description = 'Long pulling';

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
        $offset = 0;
        while (1) {
            /** @noinspection PhpUndefinedMethodInspection */
            /** @var Update[] $updates */
            $updates = Telegram::getUpdates(['offset' => $offset + 1,]);
            foreach ($updates as $update) {
                /** @noinspection PhpUnhandledExceptionInspection */
                $this->telegramService->handle($update);
                $offset = $update->getUpdateId();
            }
            sleep(1);
        }
    }
}
