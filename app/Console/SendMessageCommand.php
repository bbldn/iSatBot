<?php

namespace App\Console;

use App\Events\EventList;
use App\Helpers\EventListeners;
use Illuminate\Console\Command;
use Telegram\Bot\Laravel\Facades\Telegram;

class SendMessageCommand extends Command
{
    /** @var string */
    protected $description = 'Send Message';

    /** @var string */
    protected $signature = 'telegram:message:send {text}';

    /**
     *
     */
    public function handle(): void
    {
        $chats = EventListeners::getChatsByEvent(EventList::ORDER_NEW);
        foreach ($chats as $chat) {
            /** @noinspection PhpUndefinedMethodInspection */
            Telegram::sendMessage([
                'chat_id' => $chat->chat_id,
                'text' => $this->argument('text'),
            ]);
        }
    }
}