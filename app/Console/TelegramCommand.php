<?php

namespace App\Console;

use Illuminate\Console\Command;
use Telegram\Bot\Objects\Update;
use App\Services\TelegramService;
use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Contracts\Container\BindingResolutionException;

class TelegramCommand extends Command
{
    /** @var string */
    protected $name = 'telegram:start';

    /** @var string */
    protected $description = 'Long pulling';

    /**
     * @param TelegramService $telegramService
     * @throws BindingResolutionException
     */
    public function handle(TelegramService $telegramService): void
    {
        $offset = 0;
        while (true) {
            /** @noinspection PhpUndefinedMethodInspection */
            $updates = Telegram::getUpdates(['offset' => $offset + 1]);
            foreach ($updates as $update) {
                /** @var Update $update */
                $telegramService->handle($update);
                $offset = $update->getUpdateId();
            }
            sleep(1);
        }
    }
}