<?php

namespace App\Activities;

use App\Helpers\ChatKeeper;
use Illuminate\Support\Facades\Auth;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Objects\Update;

class StartActivity extends Activity
{
    /**
     * @param Update $update
     * @return bool
     */
    public static function able(Update $update): bool
    {
        if (null !== Auth::user()) {
            return false;
        }

        $chat = ChatKeeper::instance()->getChat();

        if (true !== $chat->data->isEmpty()) {
            return false;
        }

        return true;
    }

    /**
     * @param Update $update
     * @return int
     */
    public function handle(Update $update): int
    {
        if ('/start' !== $update->getMessage()->getText()) {
            return Activity::FAIL;
        }

        $chatId = $update->getMessage()->getChat()->getId();
        $chat = ChatKeeper::instance()->getChat();

        $chat->fill([
            'chat_id' => $chatId,
            'data' => collect(['action' => Actions::INPUT_LOGIN]),
            'user_id' => null,
        ]);
        $chat->save();

        /** @noinspection PhpUndefinedMethodInspection */
        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => 'Введите логин:',
        ]);

        return Activity::SUCCESS;
    }
}
