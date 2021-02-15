<?php

namespace App\Activities;

use App\Helpers\ChatKeeper;
use Telegram\Bot\Objects\Update;

abstract class Activity
{
    const FAIL = 0;

    const SUCCESS = 1;

    const RECYCLE = 2;

    /**
     * @param Update $update
     * @return bool
     */
    public static function able(
        /** @noinspection PhpUnusedParameterInspection */
        Update $update
    ): bool
    {
        return false;
    }

    /**
     * @param Update $update
     * @return int
     */
    public abstract function handle(Update $update): int;

    /**
     * @param Update $update
     * @return int
     */
    protected function toMenuAction(Update $update): int
    {
        $chat = ChatKeeper::instance()->getChat();
        $chat->data->put('action', Actions::MENU);
        $chat->save();
        $update->put('message', $update->getMessage()->put('text', 'Меню'));

        return Activity::RECYCLE;
    }
}
