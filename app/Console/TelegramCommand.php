<?php

namespace App\Console;

use App\Services\TelegramService;
use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Objects\Update;

class TelegramCommand extends Command
{
    /** @var string $name */
    protected $name = 'telegram:start';

    /** @var string $description */
    protected $description = 'Long pulling';


    /**
     * TelegramCommand constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param TelegramService $telegramService
     * @throws BindingResolutionException
     */
    public function handle(TelegramService $telegramService)
    {
        $offset = 0;
        while (1) {
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
