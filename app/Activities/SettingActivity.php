<?php

namespace App\Activities;

use App\Helpers\ChatKeeper;
use App\Listener;
use Illuminate\Support\Facades\Auth;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Objects\Update;

class SettingActivity extends Activity
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

        $chat = ChatKeeper::instance()->getChat();

        return in_array($chat->data->get('action'), ['setting']);
    }

    /**
     * @param Update $update
     * @return int
     */
    public function handle(Update $update): int
    {
        $actions = [
            'Настройки' => 'settingAction',
            'Подписаться на новые заказы' => 'subscribeOrderAction',
            'Отписаться от новых заказов' => 'unsubscribeOrderAction',
            'Подписаться на бэкапы' => 'subscribeBackupAction',
            'Отписаться от бэкапов' => 'unsubscribeBackupAction',
            'В Меню' => 'toMenuAction',
        ];

        if (false === key_exists($update->getMessage()->getText(), $actions)) {
            return Activity::FAIL;
        }

        $action = $actions[$update->getMessage()->getText()];

        return $this->$action($update);
    }

    /**
     * @param Update $update
     * @return int
     */
    protected function settingAction(Update $update): int
    {
        $keyboard = [];
        $chat = ChatKeeper::instance()->getChat();

        $exists = Listener::where('user_id', $chat->user->id)->where('event', 'order_new')->exists();

        if (true === $exists) {
            $keyboard[] = ['Отписаться от новых заказов',];
        } else {
            $keyboard[] = ['Подписаться на новые заказы',];
        }

        $exists = Listener::where('user_id', $chat->user->id)->where('event', 'backup')->exists();

        if (true === $exists) {
            $keyboard[] = ['Подписаться на бэкапы',];
        } else {
            $keyboard[] = ['Отписаться от бэкапов',];
        }

        $keyboard[] = ['В Меню',];
        $replyMarkup = Telegram::replyKeyboardMarkup([
            'keyboard' => $keyboard,
            'resize_keyboard' => true,
            'one_time_keyboard' => true,
        ]);

        Telegram::sendMessage([
            'chat_id' => $chat->chat_id,
            'text' => 'Выберите пункт:',
            'reply_markup' => $replyMarkup,
        ]);

        $chat->data->put('action', 'setting');
        $chat->save();

        return Activity::SUCCESS;
    }

    /**
     * @param Update $update
     * @return int
     */
    protected function subscribeOrderAction(Update $update): int
    {
        $chat = ChatKeeper::instance()->getChat();
        $exists = Listener::where('user_id', $chat->user->id)->where('event', 'order_new')->exists();

        if (true === $exists) {
            Telegram::sendMessage([
                'chat_id' => $chat->chat_id,
                'text' => 'Вы уже подписаны',
            ]);
        } else {
            Listener::create([
                'event' => 'order_new',
                'user_id' => $chat->user->id,
            ]);

            Telegram::sendMessage([
                'chat_id' => $chat->chat_id,
                'text' => 'Подписка оформлена',
            ]);
        }

        $update->getMessage()->replace(['text' => 'Настройки']);

        return Activity::RECYCLE;
    }

    /**
     * @param Update $update
     * @return int
     */
    protected function unsubscribeOrderAction(Update $update): int
    {
        $chat = ChatKeeper::instance()->getChat();
        $exists = Listener::where('user_id', $chat->user->id)->where('event', 'order_new')->exists();

        if (false === $exists) {
            Telegram::sendMessage([
                'chat_id' => $chat->chat_id,
                'text' => 'Вы не подписаны',
            ]);
        } else {
            Listener::where('user_id', $chat->user->id)->where('event', 'order_new')->delete();

            Telegram::sendMessage([
                'chat_id' => $chat->chat_id,
                'text' => 'Подписка отменена',
            ]);
        }

        $update->getMessage()->replace(['text' => 'Настройки']);

        return Activity::RECYCLE;
    }

    /**
     * @param Update $update
     * @return int
     */
    protected function subscribeBackupAction(Update $update): int
    {
        $chat = ChatKeeper::instance()->getChat();
        $exists = Listener::where('user_id', $chat->user->id)->where('event', 'backup')->exists();

        if (true === $exists) {
            Telegram::sendMessage([
                'chat_id' => $chat->chat_id,
                'text' => 'Вы уже подписаны',
            ]);
        } else {
            Listener::create([
                'event' => 'order_new',
                'user_id' => $chat->user->id,
            ]);

            Telegram::sendMessage([
                'chat_id' => $chat->chat_id,
                'text' => 'Подписка оформлена',
            ]);
        }

        $update->getMessage()->replace(['text' => 'Настройки']);

        return Activity::RECYCLE;
    }

    /**
     * @param Update $update
     * @return int
     */
    protected function unsubscribeBackupAction(Update $update): int
    {
        $chat = ChatKeeper::instance()->getChat();
        $exists = Listener::where('user_id', $chat->user->id)->where('event', 'backup')->exists();

        if (false === $exists) {
            Telegram::sendMessage([
                'chat_id' => $chat->chat_id,
                'text' => 'Вы не подписаны',
            ]);
        } else {
            Listener::where('user_id', $chat->user->id)->where('event', 'backup')->delete();

            Telegram::sendMessage([
                'chat_id' => $chat->chat_id,
                'text' => 'Подписка отменена',
            ]);
        }

        $update->getMessage()->replace(['text' => 'Настройки']);

        return Activity::RECYCLE;
    }

    /**
     * @param Update $update
     * @return int
     */
    protected function toMenuAction(Update $update): int
    {
        $chat = ChatKeeper::instance()->getChat();
        $chat->data->put('action', 'menu');
        $chat->save();
        $update->getMessage()->replace(['text' => 'Меню']);

        return Activity::RECYCLE;
    }
}
