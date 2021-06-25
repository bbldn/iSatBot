<?php

namespace App\Activities;

use App\Models\Listener;
use App\Helpers\EventList;
use App\Helpers\ChatKeeper;
use Telegram\Bot\Objects\Update;
use Illuminate\Support\Facades\Auth;
use App\Repositories\ListenerRepository;
use Telegram\Bot\Laravel\Facades\Telegram;

class SettingActivity extends Activity
{
    private ListenerRepository $listenerRepository;

    /**
     * SettingActivity constructor.
     * @param ListenerRepository $listenerRepository
     */
    public function __construct(ListenerRepository $listenerRepository)
    {
        $this->listenerRepository = $listenerRepository;
    }

    /**
     * @param Update $update
     * @return bool
     */
    public static function able(Update $update): bool
    {
        if (null === Auth::user()) {
            return false;
        }

        return Actions::SETTING === ChatKeeper::instance()->getChat()->data->get('action');
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
            'Подписаться на тестовый функционал' => 'subscribeTestAction',
            'Отписаться от тестового функционала' => 'unsubscribeTestAction',
            'В Меню' => 'toMenuAction',
        ];

        if (false === key_exists($update->getMessage()->text, $actions)) {
            return Activity::FAIL;
        }

        $action = $actions[$update->getMessage()->text];

        return $this->$action($update);
    }

    /**
     * @param Update $update
     * @return int
     */
    protected function settingAction(
        /** @noinspection PhpUnusedParameterInspection */
        Update $update
    ): int
    {
        $keyboard = [];
        $chat = ChatKeeper::instance()->getChat();

        $listener = $this->listenerRepository->findOneByUserAndEvent($chat->user, EventList::ORDER_NEW);

        if (null !== $listener) {
            $keyboard[] = ['Отписаться от новых заказов'];
        } else {
            $keyboard[] = ['Подписаться на новые заказы'];
        }

        $listener = $this->listenerRepository->findOneByUserAndEvent($chat->user, EventList::BACKUP);

        if (true !== $listener) {
            $keyboard[] = ['Отписаться от бэкапов'];
        } else {
            $keyboard[] = ['Подписаться на бэкапы'];
        }

        $listener = $this->listenerRepository->findOneByUserAndEvent($chat->user, EventList::TEST);

        if (true !== $listener) {
            $keyboard[] = ['Отписаться от тестового функционала'];
        } else {
            $keyboard[] = ['Подписаться на тестовый функционал'];
        }

        $keyboard[] = ['В Меню'];

        /** @noinspection PhpUndefinedMethodInspection */
        $replyMarkup = Telegram::replyKeyboardMarkup([
            'keyboard' => $keyboard,
            'resize_keyboard' => true,
            'one_time_keyboard' => true,
        ]);

        /** @noinspection PhpUndefinedMethodInspection */
        Telegram::sendMessage([
            'chat_id' => $chat->chat_id,
            'text' => 'Выберите пункт:',
            'reply_markup' => $replyMarkup,
        ]);

        $chat->data->put('action', Actions::SETTING);
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
        $listener = $this->listenerRepository->findOneByUserAndEvent($chat->user, EventList::ORDER_NEW);

        if (null !== $listener) {
            /** @noinspection PhpUndefinedMethodInspection */
            Telegram::sendMessage([
                'chat_id' => $chat->chat_id,
                'text' => 'Вы уже подписаны',
            ]);
        } else {
            $listener = new Listener();
            $listener->user_id = $chat->user->id;
            $listener->event = EventList::ORDER_NEW;
            $listener->save();

            /** @noinspection PhpUndefinedMethodInspection */
            Telegram::sendMessage([
                'chat_id' => $chat->chat_id,
                'text' => 'Подписка оформлена',
            ]);
        }

        $update->put('message', $update->getMessage()->put('text', 'Настройки'));

        return Activity::RECYCLE;
    }

    /**
     * @param Update $update
     * @return int
     */
    protected function unsubscribeOrderAction(Update $update): int
    {
        $chat = ChatKeeper::instance()->getChat();
        $listener = $this->listenerRepository->findOneByUserAndEvent($chat->user, EventList::ORDER_NEW);

        if (null === $listener) {
            /** @noinspection PhpUndefinedMethodInspection */
            Telegram::sendMessage([
                'chat_id' => $chat->chat_id,
                'text' => 'Вы не подписаны',
            ]);
        } else {
            $listener->delete();

            /** @noinspection PhpUndefinedMethodInspection */
            Telegram::sendMessage([
                'chat_id' => $chat->chat_id,
                'text' => 'Подписка отменена',
            ]);
        }

        $update->put('message', $update->getMessage()->put('text', 'Настройки'));

        return Activity::RECYCLE;
    }

    /**
     * @param Update $update
     * @return int
     */
    protected function subscribeBackupAction(Update $update): int
    {
        $chat = ChatKeeper::instance()->getChat();
        $listener = $this->listenerRepository->findOneByUserAndEvent($chat->user, EventList::BACKUP);

        if (null !== $listener) {
            /** @noinspection PhpUndefinedMethodInspection */
            Telegram::sendMessage([
                'chat_id' => $chat->chat_id,
                'text' => 'Вы уже подписаны',
            ]);
        } else {
            $listener = new Listener();
            $listener->user_id = $chat->user->id;
            $listener->event = EventList::BACKUP;
            $listener->save();

            /** @noinspection PhpUndefinedMethodInspection */
            Telegram::sendMessage([
                'chat_id' => $chat->chat_id,
                'text' => 'Подписка оформлена',
            ]);
        }

        $update->put('message', $update->getMessage()->put('text', 'Настройки'));

        return Activity::RECYCLE;
    }

    /**
     * @param Update $update
     * @return int
     */
    protected function unsubscribeBackupAction(Update $update): int
    {
        $chat = ChatKeeper::instance()->getChat();
        $listener = $this->listenerRepository->findOneByUserAndEvent($chat->user, EventList::BACKUP);

        if (null === $listener) {
            /** @noinspection PhpUndefinedMethodInspection */
            Telegram::sendMessage([
                'chat_id' => $chat->chat_id,
                'text' => 'Вы не подписаны',
            ]);
        } else {
            $listener->delete();

            /** @noinspection PhpUndefinedMethodInspection */
            Telegram::sendMessage([
                'chat_id' => $chat->chat_id,
                'text' => 'Подписка отменена',
            ]);
        }

        $update->put('message', $update->getMessage()->put('text', 'Настройки'));

        return Activity::RECYCLE;
    }

    /**
     * @param Update $update
     * @return int
     */
    protected function subscribeTestAction(Update $update): int
    {
        $chat = ChatKeeper::instance()->getChat();
        $listener = $this->listenerRepository->findOneByUserAndEvent($chat->user, EventList::TEST);

        if (null !== $listener) {
            /** @noinspection PhpUndefinedMethodInspection */
            Telegram::sendMessage([
                'chat_id' => $chat->chat_id,
                'text' => 'Вы уже подписаны',
            ]);
        } else {
            $listener = new Listener();
            $listener->event = EventList::TEST;
            $listener->user_id = $chat->user->id;
            $listener->save();

            /** @noinspection PhpUndefinedMethodInspection */
            Telegram::sendMessage([
                'chat_id' => $chat->chat_id,
                'text' => 'Подписка оформлена',
            ]);
        }

        $update->put('message', $update->getMessage()->put('text', 'Настройки'));

        return Activity::RECYCLE;
    }

    /**
     * @param Update $update
     * @return int
     */
    protected function unsubscribeTestAction(Update $update): int
    {
        $chat = ChatKeeper::instance()->getChat();
        $listener = $this->listenerRepository->findOneByUserAndEvent($chat->user, EventList::TEST);

        if (null === $listener) {
            /** @noinspection PhpUndefinedMethodInspection */
            Telegram::sendMessage([
                'chat_id' => $chat->chat_id,
                'text' => 'Вы не подписаны',
            ]);
        } else {
            $listener->delete();

            /** @noinspection PhpUndefinedMethodInspection */
            Telegram::sendMessage([
                'chat_id' => $chat->chat_id,
                'text' => 'Подписка отменена',
            ]);
        }

        $update->put('message', $update->getMessage()->put('text', 'Настройки'));

        return Activity::RECYCLE;
    }
}