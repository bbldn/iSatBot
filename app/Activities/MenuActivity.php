<?php

namespace App\Activities;

use App\Helpers\ChatKeeper;
use Telegram\Bot\Objects\Update;
use Illuminate\Support\Facades\Auth;
use Telegram\Bot\Laravel\Facades\Telegram;

class MenuActivity extends Activity
{
    /** @var string[] */
    protected $methods = [
        'menu',
        'setting',
    ];

    /**
     * @param Update $update
     * @return bool
     */
    public static function able(Update $update): bool
    {
        if (null === Auth::user()) {
            return false;
        }

        return Actions::MENU === ChatKeeper::instance()->getChat()->data->get('action');
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
        if (false === in_array($update->getMessage()->text, ['Меню'])) {
            return Activity::FAIL;
        }

        $keyboard = [
            ['Настройки'],
        ];

        /** @noinspection PhpUndefinedMethodInspection */
        $replyMarkup = Telegram::replyKeyboardMarkup([
            'keyboard' => $keyboard,
            'resize_keyboard' => true,
            'one_time_keyboard' => true,
        ]);

        $chat = ChatKeeper::instance()->getChat();

        /** @noinspection PhpUndefinedMethodInspection */
        Telegram::sendMessage([
            'chat_id' => $chat->chat_id,
            'text' => 'Выберите пункт:',
            'reply_markup' => $replyMarkup,
        ]);

        $chat->data->put('action', Actions::MENU);
        $chat->save();

        return Activity::SUCCESS;
    }

    /**
     * @param Update $update
     * @return int
     */
    public function setting(Update $update): int
    {
        if (false === in_array($update->getMessage()->text, ['Настройки'])) {
            return Activity::FAIL;
        }

        $chat = ChatKeeper::instance()->getChat();
        $chat->data->put('action', Actions::SETTING);
        $chat->save();

        $update->put('message', $update->getMessage()->put('text', 'Настройки'));

        return Activity::RECYCLE;
    }
}