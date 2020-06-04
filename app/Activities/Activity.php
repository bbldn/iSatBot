<?php

namespace App\Activities;

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
    public static function able(Update $update): bool
    {
        return false;
    }

    /**
     * @param Update $update
     * @return int
     */
    public abstract function handle(Update $update): int;
}
