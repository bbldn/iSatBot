<?php

namespace App\Handler;

use App\User;
use Messenger\BotSendMessage;
use Telegram\Bot\Laravel\Facades\Telegram;

class BotSendMessageHandler
{
    /**
     * @param BotSendMessage $message
     */
    public function handle(BotSendMessage $message): void
    {
        /** @var User|null $user */
        $user = User::where(User::login, $message->getLogin())->first();
        if (null === $user) {
            return;
        }

        foreach ($user->chats as $chat) {
            /** @noinspection PhpUndefinedMethodInspection */
            Telegram::sendMessage([
                'chat_id' => $chat->chat_id,
                'text' => $message->getMessage(),
            ]);
        }
    }
}