<?php

namespace App\Activities;

use App\Helpers\ChatKeeper;
use Illuminate\Support\Facades\Auth;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Objects\Update;

class MenuActivity extends Activity
{
    /**
     * @param Update $update
     * @return bool
     */
    public static function able(Update $update): bool
    {
        if (null === Auth::user()) {
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
        if (false === in_array($update->getMessage()->getText(), ['Меню', 'В меню'])) {
            return Activity::FAIL;
        }

        $keyboard = [
            ['Настройки',],
        ];

        $replyMarkup = Telegram::replyKeyboardMarkup([
            'keyboard' => $keyboard,
            'resize_keyboard' => true,
            'one_time_keyboard' => true
        ]);

        Telegram::sendMessage([
            'chat_id' => ChatKeeper::instance()->getChat()->chat_id,
            'text' => 'Выберите пункт:',
            'reply_markup' => $replyMarkup,
        ]);

        $chat = ChatKeeper::instance()->getChat();
        $chat->data['action'] = 'menu';
        $chat->save();

        return Activity::SUCCESS;
    }
}
