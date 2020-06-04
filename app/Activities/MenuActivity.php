<?php

namespace App\Activities;

use App\Helpers\ChatKeeper;
use Illuminate\Support\Facades\Auth;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Objects\Update;

class MenuActivity extends Activity
{
    /** @var array $methods */
    protected $methods = ['menu', 'setting'];

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
        foreach ($this->methods as $method) {
            $result = $this->$method($update);
            if (Activity::FAIL !== $result) {
                return $result;
            }
        }

        return Activity::FAIL;
    }

    /**
     * @param Update $update
     * @return int
     */
    public function menu(Update $update): int
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

        $chat = ChatKeeper::instance()->getChat();

        Telegram::sendMessage([
            'chat_id' => $chat->chat_id,
            'text' => 'Выберите пункт:',
            'reply_markup' => $replyMarkup,
        ]);

        $chat->data->put('action', 'menu');
        $chat->save();

        return Activity::SUCCESS;
    }

    /**
     * @param Update $update
     * @return int
     */
    public function setting(Update $update): int
    {
        if (false === in_array($update->getMessage()->getText(), ['Настройки',])) {
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

        $chat = ChatKeeper::instance()->getChat();

        Telegram::sendMessage([
            'chat_id' => $chat->chat_id,
            'text' => 'Выберите пункт:',
            'reply_markup' => $replyMarkup,
        ]);

        $chat->data->put('action', 'setting');
        $chat->save();

        return Activity::SUCCESS;
    }
}
