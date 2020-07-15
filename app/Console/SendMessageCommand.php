<?php

namespace App\Console;

use App\Events\EventList;
use App\Helpers\EventListeners;
use Illuminate\Console\Command;
use Telegram\Bot\Laravel\Facades\Telegram;

class SendMessageCommand extends Command
{
    /** @var string $signature */
    protected $signature = 'telegram:message:send {text}';

    /** @var string $description */
    protected $description = 'Send Message';

    /**
     *
     */
    public function handle(): void
    {
        $chats = EventListeners::getChatsByEvent(EventList::ORDER_NEW);

        foreach ($chats as $chat) {
            /** @noinspection PhpUndefinedMethodInspection */
            Telegram::sendDocument([
                'chat_id' => $chat->chat_id,
                'text' => $this->argument('text'),
            ]);
        }
    }
}
